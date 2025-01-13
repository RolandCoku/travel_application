<?php

require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/TravelPackage.php';

use App\Helpers\PayPalService;

class BookingController extends Controller
{
  private Booking $booking;
  private travelPackage $travelPackage;
  private PayPalService $paypalService;

  public function __construct()
  {
    global $conn;
    $this->booking = new Booking($conn);
    $this->travelPackage = new TravelPackage($conn);

    global $config;
    $this->paypalService = new PayPalService($config);
  }

  public function index(): void
  {
    $bookings = $this->booking->getAll();
    self::loadView('admin/bookings', ['bookings' => $bookings]);
  }

  public function show(): void
  {
    $booking = $this->booking->getById($_GET['id']);
    self::loadView('admin/bookings/show', ['booking' => $booking]);
  }

  public function create(): void
  {
    self::loadView('user/bookings/create');
  }

  public function store(): void
  { // krijon nje approved booking dhe pending payment dhe ben redirect drejt paypal
    session_start();

    $travelPackage = $this->travelPackage->getById($_POST['travel_package_id']);

    $booking = [
      'user_id' => $_SESSION['user_id'],
      'travel_package_id' => $_POST['travel_package_id'],
      'payment_method' => $_POST['payment_method'],
      'agency_id' => $travelPackage['agency_id'],
      'booking_date' => $travelPackage['start_date'],
      'total_price' => $travelPackage['price'],
    ];

    global $conn;
    $agencyModel = new TravelAgency($conn);
    $agency = $agencyModel->getById($travelPackage['agency_id']);
    $agencyEmail = $agency['email'];  //assuming that their email is also used for paypal

    if (!$this->booking->create($booking)) {
      // ndoshta ketu bejme nje redirect si tjerat
      echo 'Error creating booking in the database';
      exit;
    }

    $result = $this->paypalService->createOrder(
      $travelPackage['price'],
      $travelPackage['name'],
      $travelPackage['description'],
      $agencyEmail
    );

    if (!$result['success']) {
      $errorMessage = $result['error'];
      error_log("PayPal order creation failed: " . $errorMessage);
      header('Location: /payment/error?message=' . urlencode($errorMessage));
      exit;
    }

    $order = $result['data'];

    // Find the "approve" link in the response
    foreach ($order['links'] as $link) {
      if ($link['rel'] === 'approve') {
        $approveUrl = $link['href'];
        header('Location : ' . $approveUrl); // Redirect to PayPal
        exit;
      }
    }

    // If no approve link is found, handle the error
    error_log("No approve link found in PayPal response: " . print_r($order, true));
    header('Location : /payment/error?message=' . urlencode("Could not redirect to PayPal."));
    exit;
    // header('Location: /bookings');
  }

  public function captureOrder($token)
  {
    $result = $this->paypalService->captureOrder($token);
    if(! $result['success']){
      echo $result['error'];
    } else {
      parent::loadView('paymentSuccess', ['token'=> $token]);
    }
  }

  public function edit(): void
  {
    $booking = $this->booking->getById($_GET['id']);

    self::loadView('admin/booking/edit', ['booking' => $booking]);
  }

  public function update(): void
  {
    $booking = [
      'id' => $_POST['id'],
      'user_id' => $_POST['user_id'],
      'travel_package_id' => $_POST['travel_package_id'],
      'booking_date' => $_POST['booking_date'],
      'total_price' => $_POST['total_price'],
      'status' => $_POST['status']
    ];

    if ($this->booking->update($booking)) {
      header('Location: /bookings');
    } else {
      echo 'Error updating booking';
    }
  }

  public function destroy(): void
  {
    if ($this->booking->delete($_POST['id'])) {
      header('Location: /bookings');
    } else {
      echo 'Error deleting booking';
    }
  }
}
