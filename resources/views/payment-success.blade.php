<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment Successful</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .success-box {
            background: white;
            width: 90%;
            max-width: 450px;
            padding: 40px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #28a745;
            color: white;
            font-size: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 {
            color: #28a745;
            margin-bottom: 10px;
        }

        .info {
            margin-top: 25px;
            text-align: left;
        }

        .row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .button {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<div class="success-box">

    <div class="icon">✓</div>

    <h1>Payment Successful</h1>

    <p>Your payment has been completed successfully.</p>

    <div class="info">

        <div class="row">
            <strong>Order:</strong>
            <span>#{{ $order->id }}</span>
        </div>

        <div class="row">
            <strong>Amount:</strong>
            <span>{{ number_format($order->total, 2) }} EGP</span>
        </div>

        <div class="row">
            <strong>Payment:</strong>
            <span>{{ ucfirst($order->payment_method) }}</span>
        </div>

        <div class="row">
            <strong>Status:</strong>
            <span>{{ ucfirst($order->status) }}</span>
        </div>

    </div>

    <a href="/" class="button">Back to Home</a>

</div>

</body>
</html>
