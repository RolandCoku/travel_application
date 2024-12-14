<?php

require_once app_path('controllers/HomeController.php');
require_once app_path('middleware/AuthMiddleware.php');
require_once app_path('middleware/RoleMiddleware.php');

$homeController = new HomeController();

$route = $_SERVER['REQUEST_URI'];


// Public Routes
if ($route === '/login') {
    require_once app_path('views/user/login.php');
} elseif ($route === '/register') {
    require_once app_path('views/user/register.php');
}

// Protected Routes (Require Login)
elseif ($route === '/account-dashboard') {
    AuthMiddleware::handle(); // Ensure user is logged in
    require_once app_path('views/user/account-dashboard.php');
}

// Role-Based Routes (Admins Only)
elseif ($route === '/admin/dashboard') {
    AuthMiddleware::handle(); // Ensure user is logged in
    RoleMiddleware::handle('admin'); // Ensure user is an admin
    require_once app_path('views/admin/dashboard.php');
}

// Default Route
else {
    require_once app_path('views/user/index.php');
}
