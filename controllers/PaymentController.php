<?php

use App\Helpers\PayPalService;

class PaymentController extends Controller
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function store(): void
    { // krijon nje approved booking dhe pending payment dhe ben redirect drejt paypal
        // ketu duhet rishikuar radha e krijimit te booking, payment dhe paypal order
        require_once app_path('models/TravelPackage.php');
        require_once app_path('models/Booking.php');
        require_once app_path('models/Payment.php');
        require_once app_path('helpers/PayPalService.php');
        global $conn;

        $travelPackageRepo = new TravelPackage($conn);
        $bookingRepo = new Booking($conn);
        $paymentRepo = new Payment($conn);
        $paypalService = new PayPalService();

        $travelPackage = $travelPackageRepo->getById($_POST['travel_package_id']);
        // $user_id eshte edhe ne get
        $booking = [
            'user_id' => $_SESSION['user_id'],
            'travel_package_id' => $_POST['travel_package_id'],
            // 'payment_method' => $_POST['payment_method'],
            'agency_id' => $travelPackage['agency_id'],
            'booking_date' => $travelPackage['start_date'], //ketu sjam i sigurt, ndoshta do behet me post
            'total_price' => $travelPackage['price'],
        ];

        $bookingIDs = $bookingRepo->createAndGetPaymentId($booking);
        if (!$bookingIDs || !$bookingIDs['paymentId']) {
            // ndoshta ketu bejme nje redirect si tjerat
            echo 'Error creating booking in the database';
            exit();
        }
        error_log("payment ids of the new entry" . json_encode($bookingIDs));

        global $conn;
        $agencyModel = new TravelAgency($conn);
        $agency = $agencyModel->getById($travelPackage['agency_id']);
        if (!$agency) {
            echo 'Database error';
            exit();
        }

        // keto komente duhet te hiqen ne production
        // require_once app_path('models/User.php');
        // $userRepo = new User($conn);
        // $agencyEmail = $userRepo->getById($agency['user_id'])['email'];
        $agencyEmail = 'sb-85a47f36460352@business.example.com';

        $imageModel = new Image($conn);
        $image = $imageModel->getImagesByEntity('travel_package', $travelPackage['id'])->fetch_assoc();
        $imageUrl = $image['image_url'] ?? 'default.jpg';

        $result = $paypalService->createOrder(
            $travelPackage['price'],
            $travelPackage['name'],
            $travelPackage['description'],
            $agencyEmail,
            $imageUrl
        );

        if (!$result['success']) {
            $errorMessage = $result['error'];
            error_log("PayPal order creation failed: " . $errorMessage);
            header('Location: /payment/error?message=' . urlencode($errorMessage));
            exit();
        }

        $order = $result['data'];

        if (!$paymentRepo->setOrderId($bookingIDs['paymentId'], $order['id'])) {
            $error = "Couldn't update database"; // I need to handle this in a different way probably
            error_log($error);
            header('Location: /payment/error?message=' . urlencode($error));
            exit();
        }
        $_SESSION['payment_id'] = $bookingIDs['paymentId']; // payment id ne databaze
        error_log(json_encode($bookingIDs));
        $_SESSION['booking_id'] = $bookingIDs['bookingId'];
        // error_log("order id is:". $order['id']);
        // $_SESSION['paypal_order_id'] = $order['id'];  // payment id ne paypal. Different from 'token'

        // Find the "approve" link in the response
        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                $approveUrl = $link['href'];
                header('Location: ' . $approveUrl); // Redirect to PayPal
                exit();
            }
        }

        // If no approve link is found, handle the error
        error_log("No approve link found in PayPal response: " . print_r($order, true));
        header('Location : /payment/error?message=' . urlencode("Could not redirect to PayPal."));
        exit();
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
        if (!$paypalService->verifyOrder($token)) {
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
        if (!$result['success']) {
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
        require_once app_path('models/Booking.php');
        // require_once __DIR__ . '/../helpers/PayPalService.php';
        // //ktu do bejme get te dhenat e marra nga payment
        $bookingRepo = new Booking($this->conn);
        $bookingRepo->finishBooking($_SESSION['booking_id'], $_SESSION['payment_id']);
        unset($_SESSION['booking_id']);
        unset($_SESSION['payment_id']);
        // echo json_encode([
        //   'orderId' => $data['id'],
        //   'status' => $data['status'],          // COMPLETED, etc
        //   'orderDetails' => $data,
        //   'redirectUrl' => '/payment/success'. urlencode($data['id'])     // Where to redirect after success //duhet te shtoj edhe urlencoded per orderid
        // ]);
        header('Location: /payment/success?orderId=' . urlencode($data['id']));
        exit;
    }

    public function paymentSuccess(): void
    {
        // require_once app_path('models/Booking.php');
        require_once __DIR__ . '/../helpers/PayPalService.php';
        // //ktu do bejme get te dhenat e marra nga payment
        // $bookingRepo = new Booking($this->conn);
        $paypalService = new PayPalService();

        $data = $paypalService->getOrderDetails($_GET['orderId']);

        echo json_encode($data);
        // echo 'payment was successful';
        // self::loadView('user/booking/paymentSuccess.php', $data);
    }

    public function paymentFailure(): void
    {
        //ktu do bejme get errorin
        //dhe ndoshta heqim nga databaza pagesen e fundit qe deshtoi
        echo $_GET['message'];
        // self::loadView('user/booking/paymentFailure.php');
    }

    // API endpoints
    public function getTotalPaymentsByDateRange(): void
    {
        require_once app_path('models/Payment.php');
        $payment = new Payment($this->conn);

        $startDate = $_GET['startDate'];
        $endDate = $_GET['endDate'];

        $result = $payment->getTotalPaymentsByDateRange($startDate, $endDate);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

}