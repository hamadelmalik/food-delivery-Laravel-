<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    public function createPayment(
        Order $order,
        string $paymentMethod
    ): Payment {
        return DB::transaction(function () use ($order, $paymentMethod) {

            /*
            |--------------------------------------------------------------------------
            | 1. Create local payment record
            |--------------------------------------------------------------------------
            */

            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => $paymentMethod,
                'amount' => $order->total,
                'status' => 'pending',
            ]);

            /*
            |--------------------------------------------------------------------------
            | 2. Kashier configuration
            |--------------------------------------------------------------------------
            */

            $url = config('services.kashier.session_url');
            $merchantId = config('services.kashier.merchant_id');
            $authSecret = config('services.kashier.auth_secret');
            $redirectUrl = config('services.kashier.redirect_url');

            /*
            |--------------------------------------------------------------------------
            | 3. Validate configuration
            |--------------------------------------------------------------------------
            */

            if (!$url) {
                throw new Exception('Kashier session URL is missing.');
            }

            if (!$merchantId) {
                throw new Exception('Kashier merchant ID is missing.');
            }

            if (!$authSecret) {
                throw new Exception('Kashier auth secret is missing.');
            }

            if (!$redirectUrl) {
                throw new Exception('Kashier redirect URL is missing.');
            }

            /*
            |--------------------------------------------------------------------------
            | 4. Build Kashier payload
            |--------------------------------------------------------------------------
            */

            $data = [
                'paymentType' => 'professional',

                'merchantId' => $merchantId,

                'totalAmount' => (float) $order->total,

                'customerName' => $order->user->name ?? 'Customer',

                'description' => 'Payment for order #' . $order->id,

                'invoiceReferenceId' => (string) $order->id,

                'invoiceItems' => [
                    [
                        'description' => 'Order Payment',
                        'quantity' => 1,
                        'itemName' => 'Order #' . $order->id,
                        'unitPrice' => (float) $order->total,
                        'subTotal' => (float) $order->total,
                    ],
                ],

                'state' => 'submitted',

                'currency' => 'EGP',

                'tax' => 0,

                'merchantRedirect' => $redirectUrl,
            ];

            /*
            |--------------------------------------------------------------------------
            | 5. Send request to Kashier
            |--------------------------------------------------------------------------
            */

            $response = Http::timeout(60)
                ->acceptJson()
                ->withHeaders([
                    'kry' => trim($authSecret),
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $data);

            /*
            |--------------------------------------------------------------------------
            | 6. Check response
            |--------------------------------------------------------------------------
            */

            if ($response->failed()) {

                throw new Exception(
                    'Kashier payment creation failed: '
                    . $response->status()
                    . ' - '
                    . $response->body()
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 7. Decode response
            |--------------------------------------------------------------------------
            */

            $responseData = $response->json();

            /*
            |--------------------------------------------------------------------------
            | 8. Extract session information
            |--------------------------------------------------------------------------
            */

            $sessionId =
                data_get($responseData, 'session.id')
                ?? data_get($responseData, 'sessionId')
                ?? data_get($responseData, 'id');

            $redirectPaymentUrl =
                data_get($responseData, 'session.redirectUrl')
                ?? data_get($responseData, 'redirectUrl')
                ?? data_get($responseData, 'paymentUrl');

            /*
            |--------------------------------------------------------------------------
            | 9. Validate session ID
            |--------------------------------------------------------------------------
            */

            if (!$sessionId) {

                throw new Exception(
                    'Kashier session ID missing. Response: '
                    . $response->body()
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 10. Update local payment
            |--------------------------------------------------------------------------
            */

            $payment->update([
                'transaction_id' => $sessionId,
                'redirect_url' => $redirectPaymentUrl,
                'status' => 'pending',
            ]);

            /*
            |--------------------------------------------------------------------------
            | 11. Return payment
            |--------------------------------------------------------------------------
            */

            return $payment;
        });
    }
}
