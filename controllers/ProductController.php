<?php

require_once __DIR__ . '/Controller.php';

class ProductController extends Controller
{
    public function index(): void
    {
        echo PHP_EOL . 'Method index from ProductController' . PHP_EOL;
        global $conn;
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        $products = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        $this->loadView('user/products-page', ['products' => $products]);
    }

}


