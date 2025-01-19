<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0f9f0; /* Light green background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
            border: 1px solid #c3e6cb; /* Subtle green border */
        }

        .checkmark {
            font-size: 80px;
            color: #28a745; /* Green checkmark */
            margin-bottom: 20px;
        }

        h1 {
            color: #218838; /* Darker green heading */
            margin-bottom: 10px;
        }

        .details {
            margin-bottom: 30px;
            text-align: left;
        }

        .details p {
            margin: 5px 0;
        }

        .details strong {
            width: 150px;
            display: inline-block;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745; /* Green button */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease; /* Smooth transition on hover */
        }

        .button:hover {
            background-color: #1e7e34; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Successful!</h1><br/>
        <div class="details">
            <?php
            if ($data && $data['status'] == 'COMPLETED') {
                $transactionId = $data['id'];
                $amount = $data['purchase_units'][0]['amount']['value'];
                $currency = $data['purchase_units'][0]['amount']['currency_code'];
                $date = $data['update_time']; // Use update time as it's when payment was captured
                $payerEmail = $data['payer']['email_address'];
                $item = $data['purchase_units'][0]['items'][0]['name'];
                $netAmount = $data['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'];
                $fee = $data['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'];

                echo "<p><strong>Transaction ID:</strong> " . $transactionId . "</p>";
                echo "<p><strong>Item Purchased:</strong> " . $item . "</p>";
                echo "<p><strong>Amount:</strong> " . $amount . " " . $currency . "</p>";
                echo "<p><strong>PayPal Fee:</strong> " . $fee . " " . $currency . "</p>";
                echo "<p><strong>Net Amount Received:</strong> " . $netAmount . " " . $currency . "</p>";
                echo "<p><strong>Date:</strong> " . date("F j, Y, g:i a", strtotime($date)) . "</p>"; // Format the date
                echo "<p><strong>Payer Email:</strong> " . $payerEmail . "</p>";

            } else {
                echo "<p>Error: Could not process transaction data.</p>"; // Handle cases where data is invalid
            }
            ?>
        </div>
        <a href="/" class="button">Return to Home</a>
    </div>
</body>
</html>