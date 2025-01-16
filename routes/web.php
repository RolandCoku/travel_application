<?php

// Controllers
require_once app_path('controllers/UserController.php');
require_once app_path('controllers/TravelPackageController.php');
require_once app_path('controllers/BookingController.php');
require_once app_path('controllers/TravelAgencyController.php');
require_once app_path('controllers/AdminController.php');
require_once app_path('controllers/LogController.php');


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
    case '/admin/travel-agencies':
        //TODO: Fetch travel agencies (Select id, name, email, address, phone, website)
        $adminController->agencies();
        break;
    case '/admin/travel-agencies/register':
        //TODO: Store handle form submission
        $adminController->registerAgency();
        break;
    case '/admin/bookings':
        //TODO: Fetch bookings (Select id, client name, email, agency, travel package name, booking date)
        $adminController->bookings();
        break;
    case '/admin/reviews':
        //TODO: Fetch reviews (Select id, user name, package name, Comment, Rating)
        $adminController->reviews();
        break;
    case '/admin/travel-packages':
        //TODO: Fetch travel packages (Select id, agency, name, description, price, date, duration, free seats)
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
        $bookingController->store();
        break;

    // Payment processing routes
  case '/payment/processing':
    require_once app_path('controllers/PaymentController.php');
    $paymentController = new PaymentController();
    $paymentController->paypalReturn();
    break;
  case '/payment/cancel':
    // kjo eshte faqja qe paraqitet nese i ben cancel brenda paypalit
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

    // Users API Routes
    case '/api/users':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'paginate':
                $userController->paginateUsers();

            case 'filterByDate':
                $userController->getUsersByRegisteredDateRange();

            case 'countByDate':
                $userController->countUsersByRegisteredDateRange();

            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }

    // Travel Agencies API Routes
    case '/api/travel-agencies':
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

    // Travel Packages API Routes
    case '/api/travel-packages':
        $action = $_GET['action'] ?? null;

        switch ($action) {

            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }

    // Bookings API Routes
    case '/api/bookings':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'paginate':
                $bookingController->paginateBookings();
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

    //Logs API Routes
    case '/api/logs':
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
