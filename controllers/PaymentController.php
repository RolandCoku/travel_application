<?php

use App\Helpers\PayPalService;

class PaymentController extends Controller {
  private $conn;
  
  public function __construct(){
    global $conn;
    $this->conn = $conn;
  }

  public function paypalReturn()
  {
    // ketu ndoshta vendosim dicka qe mund edhe t'i beje void pageses
    self::loadView('user/bookings/loading');
  }

  public function captureOrder()  // this one returns a json, and gets fetched by js
  {
    require_once __DIR__ . '/../helpers/PayPalService.php';
    $paypalService = new PayPalService();

    $token = $_POST['token'];
    if(!$paypalService->verifyOrder($token)){
      echo json_encode([
        'success' => false,
        'error' => "You might've not finished the payment correcty",
        'redirectUrl' => '/payment/error?message=' . urlencode('possible counterfeit') // duhet te bej endpointe me ekzakte
      ]);
      exit;
    }
    // Pasi verifikojme qe token eshte i sakte, we proceed with the payment
    $result = $paypalService->captureOrder($token); // kjo nuk punon
    // ky capture eshte gjithnje gabim, se duhet te emailet e bizneseve ne paypal sandbox
    if (! $result['success']) {
      echo json_encode([
        'success' => false,
        'error' => $result['error'],
        'redirectUrl' => '/payment/error?message=' . urlencode('unsuccessful capture') // tani s'jam i sigurt si do behet endpointi i errorit per kte
      ]);
      exit;
    }
    $data = $result['data'];
    /////
    // ketu duhet te bejme update databazen me payment info
    /////
    echo json_encode([
      'success' => true,
      'orderId' => $data['orderId'],
      'status' => $result['status'],          // COMPLETED, etc
      'orderDetails' => $data,
      'redirectUrl' => '/payment/success'. urlencode($data['orderId'])     // Where to redirect after success //duhet te shtoj edhe urlencoded per orderid
    ]);
    exit;
  }

  public function paymentSuccess(): void
  {
    require_once __DIR__ . '/../models/Payment.php';
    require_once __DIR__ . '/../helpers/PayPalService.php';
    //ktu do bejme get te dhenat e marra nga payment
    $paymentRepo = new Payment($this->conn);
    $paypalService = new PayPalService();
    
    $data = $paypalService->getOrderDetails($_GET['orderId']);
    $paymentRepo->completePayment($_SESSION['payment_id']);
    unset($_SESSION['payment_id']);
    echo json_encode($data);
    // self::loadView('user/booking/paymentSuccess.php', $data);
  }

  public function paymentFailure(): void
  {
    //ktu do bejme get errorin
    //dhe ndoshta heqim nga databaza pagesen e fundit qe deshtoi
    echo $_GET['message'];
    // self::loadView('user/booking/paymentFailure.php');
  }
}