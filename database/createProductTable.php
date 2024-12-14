<?php

global $conn;
$path = __DIR__ . '/../config/db_connection.php';
require_once $path;

//Drop products table if it exists
$dropProductTableQuery = "DROP TABLE IF EXISTS products";

$createProductTableQuery = "CREATE TABLE products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT(6) UNSIGNED,
    image VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($dropProductTableQuery) === TRUE) {
    echo PHP_EOL . "Table products dropped successfully";
} else {
    echo "Error: " . $dropProductTableQuery . "<br>" . $conn->error;
}

if ($conn->query($createProductTableQuery) === TRUE) {
    echo PHP_EOL . "Table products created successfully";
} else {
    echo "Error: " . $createProductTableQuery . "<br>" . $conn->error;
}