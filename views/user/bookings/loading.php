<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="<?= base_url("/css/style.css"); ?>">
  <title>Loading...</title>
</head>

<body>
  <h1>Thank you for your order!</h1>
  <p>
    The order is currently being processed. <br />
    You'll be redirected shortly.
  </p>
  <form id='capture' action='/payment/capture' method="post">
    <input name='token' value="<?=$_GET['token']?>" hidden/>
    <button type="submit">Finalize Payment</button>
  </form>
  <script>
    const form = document.getElementById('capture');
  </script>
  <!-- <script>
    const orderId = getTokenFromUrl(); // Function to extract order ID from URL
    const checkOrderStatus = () => {
      fetch(`/payment/capture?token=${orderId}`)
        .then(response => response.json())
        .then(data => {
          if (data.status === "complete") {
            // Order is complete, redirect to confirmation page or display confirmation message
            clearInterval(intervalId); // Stop polling
            window.location.href = data.redirectUrl; // Or update the page content
          } else if (data.status === "error") {
            // Handle error
            clearInterval(intervalId);
            console.log(data.error);
          } else {
            // Order is still pending, continue polling
            console.log("Order pending...");
          }
        }).catch(error => {
          console.error("Error checking order status:", error);
          clearInterval(intervalId); // Stop polling on error
          console.log("An error occurred. Please contact support.");
        });
    };

    // Poll every few seconds
    const intervalId = setInterval(checkOrderStatus, 3000);

    // Initial check
    checkOrderStatus();

    function getTokenFromUrl() {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('token');
    }
  </script> -->

 </body>
</html>