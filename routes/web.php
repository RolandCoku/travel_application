<?php

//Controllers
require_once app_path('controllers/UserController.php');
require_once app_path('controllers/TravelPackageController.php');

//Middleware
require_once app_path('middleware/AuthMiddleware.php');
require_once app_path('middleware/RoleMiddleware.php');

//Initiate the controllers
$userController = new UserController();
$travelPackageController = new TravelPackageController();

// Get the current route
$route = $_SERVER['REQUEST_URI'];

// Remove query string from route
$route = explode('?', $route)[0];

// Remove trailing slash from route
$route = rtrim($route, '/');

//Get the query string
$queryString = $_SERVER['QUERY_STRING'];

// Public Routes
if ($route === '/login') {
    $userController->login();
} elseif ($route === '/register') {
    $userController->register();
} elseif ($route === '/confirm-email') {
    $userController->confirmEmail();
} elseif ($route === '/logout') {
    $userController->logout();
}

// Protected Routes (Require Login)
elseif ($route === '/account-dashboard') {
    AuthMiddleware::handle(); // Ensure user is logged in
    $userController->accountDashboard();
}

// Role-Based Routes (Admins Only)
elseif ($route === '/admin/dashboard') {
    AuthMiddleware::handle(); // Ensure user is logged in
    RoleMiddleware::handle('admin'); // Ensure user is an admin

    // Handle pagination
    $page = $_GET['page'] ?? 1;
    $page = (int) $page;

    $userController->adminDashboard($page);
}

// Travel Package Routes

elseif ($route === '/travel-packages') {
    $travelPackageController->index();
} elseif ($route === '/travel-packages/show') {
    $travelPackageController->show();
} elseif ($route === '/travel-packages/create') {
    $travelPackageController->create();
} elseif ($route === '/travel-packages/store') {
    $travelPackageController->store();
} elseif ($route === '/travel-packages/edit') {
    $travelPackageController->edit();
} elseif ($route === '/travel-packages/update') {
    $travelPackageController->update();
} elseif ($route === '/travel-packages/destroy') {
    $travelPackageController->destroy();
}

// endpoints


// Default Route
else {
    require_once app_path('views/user/index.php');
}
