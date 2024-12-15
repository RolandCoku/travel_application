<?php

require_once app_path('controllers/HomeController.php');
require_once app_path('controllers/UserController.php');
require_once app_path('middleware/AuthMiddleware.php');
require_once app_path('middleware/RoleMiddleware.php');

// Get the current route
$route = $_SERVER['REQUEST_URI'];



// Public Routes
if ($route === '/login') {
    UserController::login();
} elseif ($route === '/register') {
    UserController::register();
} elseif ($route === '/logout') {
    UserController::logout();
}

// Protected Routes (Require Login)
elseif ($route === '/account-dashboard') {
    AuthMiddleware::handle(); // Ensure user is logged in
    UserController::accountDashboard();}

// Role-Based Routes (Admins Only)
elseif ($route === '/admin/dashboard') {
    AuthMiddleware::handle(); // Ensure user is logged in
    RoleMiddleware::handle('admin'); // Ensure user is an admin
    UserController::adminDashboard();
}

// endpoints


// Default Route
else {
    require_once app_path('views/user/index.php');
}
