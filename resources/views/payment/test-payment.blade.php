<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Secure Payment</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #222;
        }

        .header {
            background: #ffffff;
            padding: 18px 20px;
            border-bottom: 1px solid #eee;
            font-size: 20px;
            font-weight: bold;
        }

        .container {
            width: 92%;
            max-width: 430px;
            margin: 30px auto;
        }

        .card {
            background: #ffffff;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .merchant {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin: auto;
            border-radius: 15px;
            background: #ff5722;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            font-weight: bold;
        }

        .merchant h2 {
            margin: 12px 0 5px;
        }

        .merchant p {
            color: #777;
            margin: 0;
        }

        .order-info {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .row:last-child {
            margin-bottom: 0;
        }

        .amount {
            font-size: 22px;
            font-weight: bold;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 14px;
            margin-bottom: 18px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #ff5722;
        }

        .row-input {
            display: flex;
            gap: 12px;
        }

        .row-input div {
            width: 50%;
        }

        button {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            background: #ff5722;
            color: white;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
        }

        button:active {
            transform: scale(0.98);
        }

        .secure {
            text-align: center;
            margin-top: 18px;
            color: #777;
            font-size: 13px;
        }

        .success {
            display: none;
            text-align: center;
        }

        .success-icon {
            font-size: 65px;
            margin-bottom: 15px;
        }

        .success h2 {
            margin-bottom: 10px;
        }

        .success p {
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        ← Secure Payment
    </div>

    <div class="container">

        <!-- PAYMENT -->

        <div class="card" id="paymentCard">

            <div class="merchant">

                <div class="logo">
                    H
                </div>

                <h2>Real Burgger</h2>

                <p>Secure Online Payment</p>

            </div>

            <div class="order-info">

                <div class="row">
                    <span>Order</span>
                    <strong>#1001</strong>
                </div>

                <div class="row">
                    <span>Total</span>
                    <span class="amount">250 EGP</span>
                </div>

            </div>

            <label>Card Number</label>

            <input
                type="text"
                placeholder="1234 5678 9012 3456"
                maxlength="19"
            >

            <div class="row-input">

                <div>
                    <label>Expiry Date</label>

                    <input
                        type="text"
                        placeholder="MM/YY"
                        maxlength="5"
                    >
                </div>

                <div>
                    <label>CVV</label>

                    <input
                        type="password"
                        placeholder="•••"
                        maxlength="3"
                    >
                </div>

            </div>

            <button onclick="pay()">
                Pay 250 EGP
            </button>

            <div class="secure">
                🔒 Secure Payment
            </div>

        </div>


        <!-- SUCCESS -->

        <div class="card success" id="successCard">

            <div class="success-icon">
                ✅
            </div>

            <h2>Payment Successful</h2>

            <p>
                Your payment has been completed successfully.
            </p>

            <p>
                Order #1001
            </p>

        </div>

    </div>


    <script>

        function pay() {

            document.getElementById("paymentCard").style.display = "none";

            document.getElementById("successCard").style.display = "block";

        }

    </script>

</body>

</html>
