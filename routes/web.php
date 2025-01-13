<?php
session_start();  // e vendosa kete ketu se eshte me e rekomanduar
// Controllers
require_once app_path('controllers/UserController.php');
require_once app_path('controllers/TravelPackageController.php');
require_once app_path('controllers/BookingController.php');

// Middleware
require_once app_path('middleware/AuthMiddleware.php');
require_once app_path('middleware/RoleMiddleware.php');

// Initiate the controllers
$userController = new UserController();
$travelPackageController = new TravelPackageController();
$bookingController = new BookingController();

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
  case '/logout':
    $userController->logout();
    break;

    // Protected Routes (Require Login)
  case '/account-dashboard':
    //        AuthMiddleware::handle(); // Ensure user is logged in
    $userController->accountDashboard();
    break;

    // Role-Based Routes (Admins Only)
  case '/admin/dashboard':
    AuthMiddleware::handle(); // Ensure user is logged in
    RoleMiddleware::handle('admin'); // Ensure user is an admin

    // Handle pagination
    $page = $_GET['page'] ?? 1;
    $page = (int)$page;

    $userController->adminDashboard($page);
    break;

    // Travel Package Routes (Need to add a role middleware where only agencies can access)
  case '/travel-packages':
    $travelPackageController->index();
    break;
  case '/travel-packages/show':
    $travelPackageController->show();
    break;
  case '/travel-packages/create':
    $travelPackageController->create();
    break;
  case '/travel-packages/store':
    $travelPackageController->store();
    break;
  case '/travel-packages/edit':
    $travelPackageController->edit();
    break;
  case '/travel-packages/update':
    $travelPackageController->update();
    break;
  case '/travel-packages/destroy':
    $travelPackageController->destroy();
    break;

    // Booking Routes
  case '/bookings/create':
    $bookingController->create();
    break;

  case '/bookings/store': // also starts the payment
    $bookingController->store();
    break;

  case '/payment/processing':
    $bookingController->paypalReturn();
    break;
  case '/payment/cancel':
    // kjo eshte faqja qe paraqitet nese i ben cancel brenda paypalit
    break;
  case '/payment/capture':
    $bookingController->captureOrder(); // return a json, will be fetched from js
    break;
  case '/payment/success':
    $bookingController->paymentSuccess();
    break;
  case '/payment/error':
    $bookingController->paymentFailure();
    break;

    // Keep-Alive Route (For Session Management)
  case '/keep-alive':
    session_start();
    //Check if the session is set and update the last activity timestamp
    if (isset($_SESSION['last_activity'])) {
      $_SESSION['last_activity'] = time();
    }
    // Return 200 OK
    http_response_code(200);
    break;

    // Default Route
  default:
    require_once app_path('views/user/index.php');
    break;
}
