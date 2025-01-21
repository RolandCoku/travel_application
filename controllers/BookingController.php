<?php

// use JetBrains\PhpStorm\NoReturn;

require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/User.php';

use App\Helpers\PayPalService;
use JetBrains\PhpStorm\NoReturn;

class BookingController extends Controller
{
  private Booking $booking;
  // private travelPackage $travelPackage;

  public function __construct()
  {
    global $conn;
    $this->booking = new Booking($conn);

    // $this->travelPackage = new TravelPackage($conn);
  }

  public function index(): void
  {
    $bookings = $this->booking->getAll();
    self::loadView('admin/bookings', ['bookings' => $bookings]);
  }

  public function show(): void
  {
    //        $booking = $this->booking->getById($_GET['id']);
    self::loadView('user/bookings/show');
  }

  public function create(): void
  {
    if (!isset($_SESSION['user_id'])) {
      $_SESSION['user_id'] = 1; // sa per prove
    }
    require_once app_path('models/TravelAgency.php');
    require_once app_path('models/TravelPackage.php');
    global $conn;
    $travelPackageRepo = new TravelPackage($conn);

    $travelPackageInfo = $travelPackageRepo->getByIdWithImages($_GET['travel_package_id']);

    $travelInfo = [];
    while ($row = $travelPackageInfo->fetch_assoc()) {

        $mainImage = [];

        if (!empty($row['main_image_url'])){
            $mainImage = [
                'image_url' => $row['main_image_url'],
                'alt_text' => $row['main_image_alt_text']
            ];
        }

        $reviewsResult = $travelPackageRepo->reviews($row['id']);
        $reviews = [];
        $averageRating = 0;
        while ($review = $reviewsResult->fetch_assoc()) {
            $reviews[] = [
                'name' => $review['name'],
                'rating' => $review['rating'],
                'comment' => $review['comment']
            ];
            $averageRating += $review['rating'];
        }
        $averageRating = count($reviews) > 0 ? $averageRating / count($reviews) : 0;

        $agency = $travelPackageRepo->agency($row['agency_id'])->fetch_assoc();

        $agency = [
            'id' => $agency['id'],
            'name' => $agency['name'],
            'email' => $agency['email'],
            'phone' => $agency['phone'],
            'address' => $agency['address'],
        ];

        $travelInfo = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'location' => $row['location'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'price' => $row['price'],
            'free_seats' => $row['seats'],
            'main_image' => $mainImage,
            'average_rating' => $averageRating,
            'agency' => $agency,
            'reviews' => $reviews
        ];
    }

    self::loadView('user/bookings/create', $travelInfo);
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

  public function adminShow(): void
  {
    //        $booking = $this->booking->getById($_GET['id']);
    //        $package = $this->travelPackage->getById($booking['travel_package_id']);

    self::loadView('admin/travel-agency/bookings/show',);
  }

  //API endpoints

  // #[NoReturn] 
  public function getAllPaginated(): void
  {
    $bookings = $this->booking->paginate($_GET['page'], $_GET['limit'], ['bookings.id', 'users.name', 'email', 'travel_packages.name', 'agencies.name', 'booking_date', 'booking_status']);
    header('Content-Type: application/json');
    echo json_encode($bookings);
    exit;
  }

  public function getBookingsByDateRange(): void
  {
    $bookings = $this->booking->getByDateRange($_GET['start_date'], $_GET['end_date']);
    echo json_encode($bookings);
    exit;
  }

  public function countBookingsByDateRange(): void
  {
    $nrBookings = $this->booking->countByDateRange($_GET['start_date'], $_GET['end_date']);
    header('Content-Type: application/json');
    echo json_encode($nrBookings);
    exit;
  }

  // #[NoReturn] 
  public function getTopDestinations(): void
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
  /// API Endpoints for a specific agency:
  public function getAllPaginatedForAgency(): void
  {
    error_log("agency request sent");
    $agencyId = $_SESSION['agency_id'] ?? 37; // null coalescing do hiqet ketu
    $bookings = $this->booking->paginate($_GET['page'], $_GET['limit'], ['bookings.id', 'users.name', 'email', 'travel_packages.name', 'booking_date', 'booking_status', 'payments.amount', 'payments.payment_status'], $agencyId);
    // error_log(json_encode($bookings));
    header('Content-Type: application/json');
    echo json_encode($bookings);
    exit;
  }
  public function getBookingsByDateRangeForAgency(): void
  {
    $bookings = $this->booking->getByDateRangeForAgency($_GET['start_date'], $_GET['end_date'], $_SESSION['agency_id']);
    header('Content-Type: application/json');
    echo json_encode($bookings);
    exit;
  }

  public function countBookingsByDateRangeForAgency(): void
  {
    $agency_id = $_SESSION['agency_id'];
    $nrBookings = $this->booking->countByDateRangeForAgency($_GET['start_date'], $_GET['end_date'], $agency_id);
    header('Content-Type: application/json');
    echo json_encode($nrBookings);
    exit;
  }

  public function getTopDestinationsForAgency(): void
  {
    $limit = $_GET['limit'] ?? 3;

    $agencyId = $_SESSION['agency_id'] ?? 37; // null coalescing do hiqet ketu

    $result = $this->booking->getTopDestinations($limit, $agencyId);
    header('Content-Type: application/json');

    $topDestinations = [];
    while ($row = $result->fetch_assoc()) {
      $topDestinations[] = $row;
    }

    echo json_encode($topDestinations);
    exit;
  }
}
