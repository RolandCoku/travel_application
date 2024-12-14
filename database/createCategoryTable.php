<?php

global $conn;

$path = __DIR__ . '/../config/db_connection.php';
require_once $path;

//Drop the categories table if it exists
$dropCategoryTableQuery = "DROP TABLE IF EXISTS categoties";

//Create the categories table query
$createCategoryTableQuery = "CREATE TABLE categories (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if($conn->query($dropCategoryTableQuery) === TRUE){
    echo PHP_EOL . "Table categories dropped successfully";
} else {
    echo "Error: " . $dropCategoryTableQuery . "<br>" . $conn->error;
}

if($conn->query($createCategoryTableQuery) === TRUE){
    echo PHP_EOL . "Table categories created successfully";
} else {
    echo "Error: " . $createCategoryTableQuery . "<br>" . $conn->error;
}