<?php

// use JetBrains\PhpStorm\NoReturn;

require_once __DIR__ . '/../models/Booking.php';
// require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/User.php';
// require_once __DIR__ . '/../models/TravelPackage.php';
// require_once __DIR__ . '/../helpers/PayPalService.php';

use App\Helpers\PayPalService;

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
    $_SESSION['user_id'] = 1; // sa per prove
    self::loadView('user/bookings/create');
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

        self::loadView('admin/travel-agency/bookings/show', );
    }

    //API endpoints
    // #[NoReturn] 
    public function paginateBookings(): void
    {
        $bookings = $this->booking->paginate($_GET['page'], $_GET['limit'], ['id', 'user_id', 'travel_package_id', 'booking_date', 'booking_status']);
        echo json_encode($bookings);
        exit;
    }

    // #[NoReturn] 
    public function getBookingsByDateRange(): void
    {
        $bookings = $this->booking->getByDateRange($_GET['start_date'], $_GET['end_date']);
        echo json_encode($bookings);
        exit;
    }

    // #[NoReturn] 
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
}