<?php

use JetBrains\PhpStorm\NoReturn;

require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/TravelPackage.php';
require_once __DIR__ . '/../helpers/PayPalService.php';

use App\Helpers\PayPalService;

class BookingController extends Controller
{
  private Booking $booking;
//  private Payment $payment;
  private travelPackage $travelPackage;
//  private PayPalService $paypalService;
//
  public function __construct()
  {
    global $conn;
    $this->booking = new Booking($conn);
    $this->travelPackage = new TravelPackage($conn);
//    $this->payment = new Payment($conn);
//
//    $this->paypalService = new PayPalService();
  }
//
//  public function index(): void
//  {
//    $bookings = $this->booking->getAll();
//    self::loadView('admin/bookings', ['bookings' => $bookings]);
//  }
//
//    public function show(): void
//    {
////        $booking = $this->booking->getById($_GET['id']);
//        self::loadView('user/bookings/show');
//    }
//
//  public function create(): void
//  {
//    $_SESSION['user_id'] = 1; // sa per prove
//    self::loadView('user/bookings/create');
//  }
//
//  public function store(): void
//  { // krijon nje approved booking dhe pending payment dhe ben redirect drejt paypal
//    // ketu duhet rishikuar radha e krijimit te booking, payment dhe paypal order
//
//    $travelPackage = $this->travelPackage->getById($_POST['travel_package_id']);
//    // $user_id eshte edhe ne get
//    $booking = [
//      'user_id' => $_SESSION['user_id'],
//      'travel_package_id' => $_POST['travel_package_id'],
//      // 'payment_method' => $_POST['payment_method'],
//      'agency_id' => $travelPackage['agency_id'],
//      'booking_date' => $travelPackage['start_date'], //ketu sjam i sigurt, ndoshta do behet me post
//      'total_price' => $travelPackage['price'],
//    ];
//
//    $paymentId =$this->booking->createAndGetPaymentId($booking);
//    if ($paymentId === null) {
//      // ndoshta ketu bejme nje redirect si tjerat
//      echo 'Error creating booking in the database';
//      exit();
//    }
//    error_log("payment id of the new entry". $paymentId);
//
//    global $conn;
//    $agencyModel = new TravelAgency($conn);
//    $agency = $agencyModel->getById($travelPackage['agency_id']);
//    if(!$agency){
//      echo 'Database error';
//      exit();
//    }
//    $agencyEmail = $agency['email'];  //assuming that their email is also used for paypal
//
//    $imageModel = new Image($conn);
//    $image = $imageModel->getByTravelPackageId($_POST['travel_package_id']);
//    $imageUrl = $image['image_url'] ?? 'default.jpg';
//
//    $result = $this->paypalService->createOrder(
//      $travelPackage['price'],
//      $travelPackage['name'],
//      $travelPackage['description'],
//      $agencyEmail,
//      $imageUrl
//    );
//
//    if (!$result['success']) {
//      $errorMessage = $result['error'];
//      error_log("PayPal order creation failed: " . $errorMessage);
//      header('Location: /payment/error?message=' . urlencode($errorMessage));
//      exit();
//    }
//
//    $order = $result['data'];
//
//    if(!$this->payment->setOrderId($paymentId, $order['id'])){
//      $error ="Couldn't update database"; // I need to handle this in a different way probably
//      error_log($error);
//      header('Location: /payment/error?message=' . urlencode($error));
//      exit();
//    }
//    $_SESSION['payment_id'] = $paymentId; // payment id ne databaze
//    // error_log("order id is:". $order['id']);
//    // $_SESSION['paypal_order_id'] = $order['id'];  // payment id ne paypal. Different from 'token'
//
//    // Find the "approve" link in the response
//    foreach ($order['links'] as $link) {
//      if ($link['rel'] === 'approve') {
//        $approveUrl = $link['href'];
//        header('Location: ' . $approveUrl); // Redirect to PayPal
//        exit();
//      }
//    }
//
//    // If no approve link is found, handle the error
//    error_log("No approve link found in PayPal response: " . print_r($order, true));
//    header('Location : /payment/error?message=' . urlencode("Could not redirect to PayPal."));
//    exit();
//  }
//
//  public function paypalReturn()
//  {
//    // ketu ndoshta vendosim dicka qe mund edhe t'i beje void pageses
//    self::loadView('user/bookings/loading');
//  }
//
//  public function captureOrder()  // this one returns a json, and gets fetched by js
//  {
//    $token = $_POST['token'];
//    if(!$this->paypalService->verifyOrder($token)){
//      echo json_encode([
//        'success' => false,
//        'error' => "You might've not finished the payment correcty",
//        'redirectUrl' => '/payment/error?message=' . urlencode('possible counterfeit') // duhet te bej endpointe me ekzakte
//      ]);
//      exit;
//    }
//    // Pasi verifikojme qe token eshte i sakte, we proceed with the payment
//    $result = $this->paypalService->captureOrder($token); // kjo nuk punon
//    // ky capture eshte gjithnje gabim, se duhet te emailet e bizneseve ne paypal sandbox
//    if (! $result['success']) {
//      echo json_encode([
//        'success' => false,
//        'error' => $result['error'],
//        'redirectUrl' => '/payment/error?message=' . urlencode('unsuccessful capture') // tani s'jam i sigurt si do behet endpointi i errorit per kte
//      ]);
//      exit;
//    }
//    $data = $result['data'];
//    /////
//    // ketu duhet te bejme update databazen me payment info
//    /////
//    echo json_encode([
//      'success' => true,
//      'orderId' => $data['orderId'],
//      'status' => $result['status'],          // COMPLETED, etc
//      'orderDetails' => $data,
//      'redirectUrl' => '/payment/success'. urlencode($data['orderId'])     // Where to redirect after success //duhet te shtoj edhe urlencoded per orderid
//    ]);
//    exit;
//  }
//
//  public function edit(): void
//  {
//    $booking = $this->booking->getById($_GET['id']);
//
//    self::loadView('admin/booking/edit', ['booking' => $booking]);
//  }
//
//  public function paymentSuccess(): void
//  {
//    //ktu do bejme get te dhenat e marra nga payment
//    $data = $this->paypalService->getOrderDetails($_GET['orderId']);
//    $this->payment->completePayment($_SESSION['payment_id']);
//    unset($_SESSION['payment_id']);
//    echo json_encode($data);
//    // self::loadView('user/booking/paymentSuccess.php', $data);
//  }
//
//  public function paymentFailure(): void
//  {
//    //ktu do bejme get errorin
//    //dhe ndoshta heqim nga databaza pagesen e fundit qe deshtoi
//    echo $_GET['message'];
//    // self::loadView('user/booking/paymentFailure.php');
//  }
//
//  public function update(): void
//  {
//    $booking = [
//      'id' => $_POST['id'],
//      'user_id' => $_POST['user_id'],
//      'travel_package_id' => $_POST['travel_package_id'],
//      'booking_date' => $_POST['booking_date'],
//      'total_price' => $_POST['total_price'],
//      'status' => $_POST['status']
//    ];
//
//    if ($this->booking->update($booking)) {
//      header('Location: /bookings');
//    } else {
//      echo 'Error updating booking';
//    }
//  }
//
//    public function destroy(): void
//    {
//        if ($this->booking->delete($_POST['id'])) {
//            header('Location: /bookings');
//        } else {
//            echo 'Error deleting booking';
//        }
//    }
//
//    public function adminShow(): void
//    {
////        $booking = $this->booking->getById($_GET['id']);
////        $package = $this->travelPackage->getById($booking['travel_package_id']);
//
//        self::loadView('admin/travel-agency/bookings/show', );
//    }

    //API endpoints
    #[NoReturn] public function paginateBookings(): void
    {
        $bookings = $this->booking->paginate($_GET['page'], $_GET['limit'], ['id', 'user_id', 'travel_package_id', 'booking_date', 'booking_status']);
        echo json_encode($bookings);
        exit;
    }

    #[NoReturn] public function getBookingsByDateRange(): void
    {
        $bookings = $this->booking->getByDateRange($_GET['start_date'], $_GET['end_date']);
        echo json_encode($bookings);
        exit;
    }

    #[NoReturn] public function countBookingsByDateRange(): void
    {
        $nrBookings = $this->booking->countByDateRange($_GET['start_date'], $_GET['end_date']);
        header('Content-Type: application/json');
        echo json_encode($nrBookings);
        exit;
    }

    #[NoReturn] public function getTopDestinations(): void
    {
        $limit = $_GET['limit'] ?? 3;
        $result = $this->booking->getTopDestinations($limit);
        header('Content-Type: application/json');

        $topDestinations = [];
        while ($row = $result->fetch_assoc()) {
            $topDestinations[] = $row;
        }

        echo json_encode($topDestinations);
        exit;
    }
}