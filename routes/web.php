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
    case '/about':
        $userController->about();
        break;
    case '':
        $userController->index();
        break;

        //User profile routes
    case '/user/update':
        $authMiddleware->handle();
        $userController->put();
        break;
    case '/user/change-password':
        $authMiddleware->handle();
        $userController->changePassword();
        break;

    // Protected Routes (Require Login)
    case '/account-dashboard':
        $authMiddleware->handle();
        $userController->accountDashboard();
        break;
    case '/logout':
        $userController->logout();


    // Role-Based Routes (Admins Only) TODO: Add auth and role controller for verification
    case '/admin/dashboard':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $adminController->dashboard();
        break;
    case '/admin/profile':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $adminController->profile();
        break;
    case '/admin/travel-agencies':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $adminController->agencies();
        break;
    case '/admin/travel-agencies/register':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $adminController->registerAgency();
        break;
    case '/admin/travel-agencies/store':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $travelAgencyController->store();
        break;
    case '/admin/bookings':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $adminController->bookings();
        break;
    case '/admin/reviews':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $adminController->reviews();
        break;
    case '/admin/travel-packages':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $adminController->travelPackages();
        break;

    // Role-Based Routes (Travel Agencies Only)
    case '/travel-agency/admin/dashboard':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        $travelAgencyController->adminDashboard();
        break;
    case '/travel-agency/admin/bookings':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        $travelAgencyController->bookings();
        break;
    case '/travel-agency/admin/travel-packages':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        $travelAgencyController->travelPackages();
        break;
    case '/travel-agency/admin/reviews':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        $travelAgencyController->reviews();
        break;

    //Travel package admin routes
    case '/travel-agency/admin/travel-packages/show':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        $travelPackageController->adminShow();
        break;
    case '/travel-agency/admin/travel-packages/create':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        $travelPackageController->create();
        break;
    case '/travel-agency/admin/travel-packages/store':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        error_log("So it did enter here");
        $travelPackageController->store();
        break;
    case '/travel-agency/admin/travel-packages/edit':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        $travelPackageController->edit();
        break;
    case '/travel-agency/admin/travel-packages/update':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        $travelPackageController->update();
        break;
    case '/travel-agency/admin/travel-packages/destroy':
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
        $travelPackageController->destroy();
        break;

    //Travel Agency Routes (Public)
    case '/travel-agencies':
        $travelAgencyController->index();
        break;
    case '/travel-agencies/show':
        $travelAgencyController->show();
        break;

    //Travel package routes (Public)
    case '/travel-packages':
        $travelPackageController->index();
        break;
    case '/travel-packages/show':
        $travelPackageController->show();
        break;

    // Booking Routes
    case '/bookings/create':
        $authMiddleware->handle();
        $bookingController->create();
        break;
    case '/bookings/store': // also starts the payment
        $authMiddleware->handle();
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->store();
        break;

    // Payment processing routes
    case '/payment/processing':
        $authMiddleware->handle();
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->paypalReturn();
        break;
    case '/payment/cancel':
        $authMiddleware->handle();
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->paymentCancel();
        break;
    case '/payment/capture':
        $authMiddleware->handle();
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->captureOrder();
        break;
    case '/payment/success':
        $authMiddleware->handle();
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->paymentSuccess();
        break;
    case '/payment/error':
        $authMiddleware->handle();
        require_once app_path('controllers/PaymentController.php');
        $paymentController = new PaymentController();
        $paymentController->paymentFailure();
        break;

    // Admin Booking Routes
    case '/admin/bookings/show':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $bookingController->adminShow();
        break;
    case '/admin/bookings/edit':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $bookingController->edit();
        break;
    case '/admin/bookings/update':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $bookingController->update();
        break;
    case '/admin/bookings/destroy':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
        $bookingController->destroy();
        break;

    case '/search':
        require app_path('controllers/SearchController.php');
        $searchController = new SearchController();
        $searchController->search();
        break;

    /* ADMIN API ROUTES TO FETCH DATA FOR DASHBOARD */
    // Users admin API Routes
    case '/api/admin/users':
       $authMiddleware->handle();
       RoleMiddleware::handle('admin');
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
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
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
            case 'getAll':
                $travelAgencyController->getAll();

            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }

    // Travel Packages admin API Routes
    case '/api/admin/travel-packages':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
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

    case '/api/travel-packages':
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'paginate':
                $travelPackageController->getAllPaginated();
            case 'topPackages':
                $travelPackageController->getTopPackagesWithImagesPaginated();
            case 'getPaginatedWithImages':
                $travelPackageController->getPaginatedWithImages();
            case 'latest':
                $travelPackageController->getLatestPackagesWithImagesPaginated();
            case 'closest':
                $travelPackageController->getClosestPackagesWithImagesPaginated();
            case 'getById':
                $travelPackageController->getByIdWithImagesAndAgency();

            default:
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action parameter']);
                exit;
        }

    // Bookings API Routes
    case '/api/admin/bookings':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
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
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
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
        $authMiddleware->handle();
        RoleMiddleware::handle('agency_admin');
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
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
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

    //Logs admin API Routes
    case '/api/admin/logs':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
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

    // Payment admin API Routes
    case '/api/admin/payments':
        $authMiddleware->handle();
        RoleMiddleware::handle('admin');
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

    // Default Route (404)
    default:
        require_once app_path('views/errors/404.php');
        break;
}
