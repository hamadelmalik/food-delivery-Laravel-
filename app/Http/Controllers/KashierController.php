<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KashierController extends Controller
{

    public function createPayment()
    {
        $url = config('services.kashier.payment_url');

        $payload = [
            'merchantId' => 'MID-49571-764',
            'amount' => '100',
            'currency' => 'EGP',

            'customer' => [
                'name' => 'Test Customer',
                'reference' => 'CUST-001',
            ],

            'description' => 'Test Payment',

            'merchantOrderId' => 'ORD-' . time(),

            'merchantRedirect' =>
                'https://3cbd-156-193-43-140.ngrok-free.app/api/payment/callback',
        ];

        $headers = [
            'Authorization' => config('services.kashier.authorization'),
            'api-key' => config('services.kashier.api_key'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        Log::info('Kashier URL:', [
            'url' => $url,
        ]);

        Log::info('Kashier Headers:', [
            'Authorization' => !empty($headers['Authorization'])
                ? 'PRESENT'
                : 'MISSING',

            'api-key' => !empty($headers['api-key'])
                ? 'PRESENT'
                : 'MISSING',
        ]);

        Log::info('Kashier Payload:', $payload);

        try {

            $response = Http::withHeaders($headers)
                ->post($url, $payload);

            Log::info('Kashier Response:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->failed()) {

                return response()->json([
                    'error' => true,
                    'status' => $response->status(),
                    'body' => $response->json(),
                ], $response->status());
            }

            $data = $response->json();

            if (!empty($data['sessionUrl'])) {

                return redirect()->away(
                    $data['sessionUrl']
                );
            }

            return response()->json([
                'error' => true,
                'message' => 'Kashier did not return sessionUrl',
                'response' => $data,
            ], 500);

        } catch (\Throwable $e) {

            Log::error('Kashier Exception:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'error' => true,
                'message' => 'Kashier connection failed',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Kashier Payment Callback
     */
    public function paymentCallback(Request $request)
    {
        Log::info('Kashier Callback:', [
            'query' => $request->query(),
            'body' => $request->all(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment callback received',
            'data' => $request->all(),
        ]);
    }
}
