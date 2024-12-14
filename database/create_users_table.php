<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

// Drop the users table if it exists
$dropUsersTableQuery = "DROP TABLE IF EXISTS users";

// Create the users table query
$createUsersTableQuery = "CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user', 'agency') DEFAULT 'user',
    email_confirmed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($dropUsersTableQuery) === TRUE) {
    echo PHP_EOL . "Table users dropped successfully";
} else {
    echo "Error: " . $dropUsersTableQuery . "<br>" . $conn->error;
}

if ($conn->query($createUsersTableQuery) === TRUE) {
    echo PHP_EOL . "Table users created successfully";
} else {
    echo "Error: " . $createUsersTableQuery . "<br>" . $conn->error;
}

// Insert a default admin user ( only for testing purposes )
$adminName = 'Admin';
$adminEmail = 'admin@admin.com';
$adminPassword = password_hash('admin', PASSWORD_DEFAULT);
$adminRole = 'admin';
$adminEmailConfirmed = true;

$insertAdminUserQuery = "INSERT INTO users (name, email, password, role, email_confirmed) VALUES ('$adminName', '$adminEmail', '$adminPassword', '$adminRole', '$adminEmailConfirmed')";

if ($conn->query($insertAdminUserQuery) === TRUE) {
    echo PHP_EOL . "Admin user inserted successfully";
} else {
    echo "Error: " . $insertAdminUserQuery . "<br>" . $conn->error;
}

