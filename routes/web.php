<?php

require_once app_path('controllers/ProductController.php');
require_once app_path('controllers/HomeController.php');

$productController = new ProductController();
$homeController = new HomeController();

$route = $_SERVER['REQUEST_URI'];

echo $route;

switch ($route){
    case '/ecommerce/':
        $homeController->index();
        break;
    case '/ecommerce/products/':
        $productController->index();
        break;
}