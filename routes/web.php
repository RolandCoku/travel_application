<?php

// Controllers
require_once app_path('controllers/UserController.php');
require_once app_path('controllers/TravelPackageController.php');
require_once app_path('controllers/BookingController.php');
require_once app_path('controllers/TravelAgencyController.php');
require_once app_path('controllers/AdminController.php');
require_once app_path('controllers/LogController.php');
require_once app_path('controllers/ReviewController.php');
require_once app_path('controllers/PaymentController.php');


// Middleware
require_once app_path('middleware/AuthMiddleware.php');
require_once app_path('middleware/RoleMiddleware.php');

// Initiate the controllers
$userController = new UserController();
$travelPackageController = new TravelPackageController();
$bookingController = new BookingController();
$travelAgencyController = new TravelAgencyController();
$adminController = new AdminController();
$logController = new LogController();
$reviewController = new ReviewController();
$paymentController = new PaymentController();

//Initiate the middleware
$authMiddleware = new AuthMiddleware();

// Get the current route
$route = $_SERVER['REQUEST_URI'];

// Remove query string from route
$route = explode('?', $route)[0];

// Remove trailing slash from route
$route = rtrim($route, '/');

// Get the query string
// $queryString = $_SERVER['QUERY_STRING'];

// Routing
switch ($route) {
    // Public Routes
    case '/login':
        $userController->login();
        break;
    case '/register':
        $userController->register();
        break;
    case '/confirm-email':
        $userController->confirmEmail();
        break;
    case '/forgot-password':
        $userController->forgotPassword();
        break;
    case '/reset-password':
        $userController->resetPassword();
        break;

    // Protected Routes (Require Login)
    case '/account-dashboard':
        $authMiddleware->handle(); // Ensure user is logged in
        $userController->accountDashboard();
        break;
    case '/logout':
        $userController->logout();


    // Role-Based Routes (Admins Only) TODO: Add auth and role controller for verification
    case '/admin/dashboard':
        //TODO: - Fetch the data for total income in 7 days
        $adminController->dashboard();
        break;
    case '/admin/profile':
        $adminController->profile();
        break;
    case '/admin/travel-agencies':
        $adminController->agencies();
        break;
    case '/admin/travel-agencies/register':
        $adminController->registerAgency();
        break;
    case '/admin/travel-agencies/store':
        $travelAgencyController->store();
        break;
    case '/admin/bookings':
        $adminController->bookings();
        break;
    case '/admin/reviews':
        $adminController->reviews();
        break;
    case '/admin/travel-packages':
        $adminController->travelPackages();
        break;

    // Role-Based Routes (Travel Agencies Only)
    case '/travel-agency/admin/dashboard':
        //TODO: - Fetch the data, total income and fully booked packages
        //      - Fetch the latest updates
        //      - Fetch top destinations
        $travelAgencyController->adminDashboard();
        break;
    case '/travel-agency/admin/bookings':
        //TODO: - Fetch bookings (Select client name, client email, travel package name, booking date, booking status, payment amount, payment status)
        //      - Fetch Top 5 bookings
        $travelAgencyController->bookings();
        break;
    case '/travel-agency/admin/travel-packages':
        //TODO: - Fetch travel packages (Select name, description, price, date, duration, free seats)
        //      - Fetch Top 5 packages
        $travelAgencyController->travelPackages();
        break;
    case '/travel-agency/admin/reviews':
        //TODO: - Fetch reviews (Select user name, package name, comment, rating)
        //      - Fetch latest reviews
        $travelAgencyController->reviews();
        break;


    //Travel package routes
    case '/travel-packages':
        $travelPackageController->index();
        break;
    case '/travel-packages/show':
        $travelPackageController->show();
        break;

    //Travel package admin routes
    case '/travel-agency/admin/travel-packages/show':
        //TODO: Fetch travel package details (Select name, description, price, date, duration, free seats) from id
        $travelPackageController->adminShow();
        break;
    case '/travel-agency/admin/travel-packages/create':
        $travelPackageController->create();
        break;
    case '/travel-agency/admin/travel-packages/store':
        //TODO: Handle form submission
        $travelPackageController->store();
        break;
    case '/travel-agency/admin/travel-packages/edit':
        //TODO: Fetch travel package details (Select name, description, price, date, duration, free seats) from id
        $travelPackageController->edit();
        break;
    case '/travel-agency/admin/travel-packages/update':
        //TODO: Handle form submission
        $travelPackageController->update();
        break;
    case '/travel-agency/admin/travel-packages/destroy':
        //TODO: Delete travel package
        $travelPackageController->destroy();
        break;

    // Booking Routes
    case '/bookings/create':
        $bookingController->create();
        break;
    case '/bookings/store': // also starts the payment
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->store();
        break;

    // Payment processing routes
    case '/payment/processing':
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->paypalReturn();
        break;
    case '/payment/cancel':
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->paymentCancel();
        break;
    case '/payment/capture':
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->captureOrder(); // return a json, will be fetched from js
        break;
    case '/payment/success':
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->paymentSuccess();
        break;
    case '/payment/error':
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->paymentFailure();
        break;
    // Admin Booking Routes
    case '/admin/bookings/show':
        // TODO: Fetch booking details (Select client name, client email, travel package name, booking date, booking status, payment amount, payment status) from id
        $bookingController->adminShow();
        break;
    case '/admin/bookings/edit':
        // TODO: Fetch booking details (Select client name, client email, travel package name, booking date, booking status, payment amount, payment status) from id
        $bookingController->edit();
        break;
    case '/admin/bookings/update':
        // TODO: Handle form submission
        $bookingController->update();
        break;
    case '/admin/bookings/destroy':
        // TODO: Delete booking
        $bookingController->destroy();
        break;

    /* ADMIN API ROUTES TO FETCH DATA FOR DASHBOARD */

    // Users API Routes
    case '/api/admin/users':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'paginate':
                $userController->paginateUsers();

            case 'filterByDate':
                $userController->getUsersByRegisteredDateRange();

            case 'countByDate':
                $userController->countUsersByRegisteredDateRange();

            case 'search':
                $userController->searchUsers();


            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }

    // Travel Agencies admin API Routes
    case '/api/admin/travel-agencies':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'paginate':
                $travelAgencyController->paginateTravelAgencies();
            case 'topAgencies':
                $travelAgencyController->getTopAgencies();

            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }
    //Travel Agencies user API Routes
    case '/api/travel-agencies':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'paginate':
                $travelAgencyController->paginateTravelAgencies();
            case 'topAgencies':
                $travelAgencyController->getTopAgencies();
            case 'getPaginatedWithImages':
                $travelAgencyController->getPaginatedWithImages();
            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }

    // Travel Packages API Routes
    case '/api/admin/travel-packages':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'paginate':
                $travelPackageController->getAllPaginated();
            case 'topPackages':
                $travelPackageController->getTopPackages();

            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }

    // Bookings API Routes
    case '/api/admin/bookings':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'paginate':
                $bookingController->getAllPaginated();
            case 'countByDate':
                $bookingController->countBookingsByDateRange();
            case 'topDestinations':
                $bookingController->getTopDestinations();

            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }
    // Bookings API Routes for Travel Agency
    case '/api/travel-agency/bookings':
      $action = $_GET['action'] ?? null;
      switch ($action) {
          case 'paginate':
              $bookingController->getAllPaginatedForAgency();
          case 'countByDate':
              $bookingController->countBookingsByDateRangeForAgency();
          case 'topDestinations':
              $bookingController->getTopDestinationsForAgency();

          default:
              header('Content-Type: application/json');
              http_response_code(400);
              echo json_encode(['error' => 'Invalid action parameter']);
              exit;
      }
    // Travel Package Api for Travel Agencies

    case '/api/travel-agency/travel-packages':
      $action = $_GET['action'] ?? null;

      switch ($action) {
          case 'paginate':
              $travelPackageController->getAllPaginatedForAgency();
          case 'topPackages':
              $bookingController->getTopDestinationsForAgency();

          default:
              header('Content-Type: application/json');
              http_response_code(400);
              echo json_encode(['error' => 'Invalid action parameter']);
              exit;
      }

    // Reviews API Routes
    case '/api/admin/reviews':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'paginate':
                $reviewController->getAllPaginated();
            case 'latest':
                $reviewController->getLatestReviews();


            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }

    //Logs API Routes
    case '/api/admin/logs':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'latest':
                $logController->getLatestLogsAndUserInfo();
            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }

    // Payment API Routes
    case '/api/admin/payments':
        $action = $_GET['action'] ?? null;

        switch ($action):
            case 'totalByDateRange':
                $paymentController->getTotalPaymentsByDateRange();
                break;

            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        endswitch;
        break;


    // Keep-Alive Route (For Session Management)
    case '/keep-alive':
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //Check if the session is set and update the last activity timestamp
        if (isset($_SESSION['last_activity'])) {
            $_SESSION['last_activity'] = time();
        }
        // Return 200 OK
        http_response_code(200);
        break;

//     Default Route
    default:
        require_once app_path('views/user/index.php');
        break;
}
