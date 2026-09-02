<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kashier Payment</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .payment-box {
            background: white;
            width: 400px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .payment-box h1 {
            margin-bottom: 10px;
        }

        .amount {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #0066ff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #0052cc;
        }
    </style>
</head>

<body>

<div class="payment-box">

    <h1>Kashier Payment</h1>

    <p>Test Payment</p>

    <div class="amount">
        100 EGP
    </div>

 <form action="{{ url('/api/kashier/payment') }}" method="POST">
    @csrf

    <button type="submit">
        Pay with Kashier
    </button>
</form>
</div>

</body>
</html>
