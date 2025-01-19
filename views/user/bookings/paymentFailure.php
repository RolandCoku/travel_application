<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
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
        }

        .cross {
            font-size: 80px;
            color: #dc3545; /* Red */
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Blue */
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .error-details{
            text-align: left;
        }
        .error-details strong{
            width: 150px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cross">&#10006;</div>
        <h1>Payment Failed</h1>
        <p>We're sorry, but your payment could not be processed. Please check your payment information and try again.</p>
        <div class="error-details">
            <?php
                if(isset($_GET['error'])){
                    $errorCode = $_GET['error'];
                    $errorMessages = [
                        'invalid_card' => "The card number you entered is invalid.",
                        'insufficient_funds' => "There are insufficient funds in your account.",
                        'expired_card' => "Your card has expired.",
                        'transaction_declined' => "The transaction was declined by your bank.",
                        'payment_cancelled' => "The payment was cancelled by the user.",
                        'other' => "An unexpected error occurred. Please try again later."
                    ];
                    $errorMessage = $errorMessages[$errorCode] ?? $errorMessages['other'];
                    echo "<p><strong>Error Code:</strong> " . $errorCode . "</p>";
                    echo "<p><strong>Error Message:</strong> " . $errorMessage . "</p>";
                } else if( isset($_GET['message'])){
                  echo "<p><strong>Error Message:</strong> " . $_GET['message'] . "</p>";
                }
            ?>
        </div>
        <a href="/" class="button">Return to Home</a>
    </div>
</body>
</html>