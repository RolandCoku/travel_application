<!DOCTYPE html>
<html>

<head>
  <title>Processing Payment</title>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="<?= base_url("/css/style.css"); ?>">
  <title>Loading...</title>
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      margin-top: 50px;
    }

    .spinner {
      border: 16px solid #f3f3f3;
      /* Light grey */
      border-top: 16px solid #3498db;
      /* Blue */
      border-radius: 50%;
      width: 120px;
      height: 120px;
      animation: spin 2s linear infinite;
      margin: 0 auto;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body>
  <h1>Processing Payment...</h1>
  <div class="spinner"></div>
  <p>Your payment is being processed. Please wait. Do not refresh or close this page.</p>
  <form id='capture' action='/payment/capture' method="post">
    <input name='token' value="<?= $_GET['token'] ?>" hidden />
  </form>
  <script>
    document.getElementById('capture').submit();
  </script>
</body>

</html>

