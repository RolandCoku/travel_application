<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the users table if it exists
        $dropUsersTableQuery = "DROP TABLE IF EXISTS users";
        if ($conn->query($dropUsersTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'users' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the users table
        $createUsersTableQuery = "
            CREATE TABLE users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                email VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'user') DEFAULT 'user',
                email_confirmed BOOLEAN DEFAULT FALSE,
                email_confirmation_token VARCHAR(255) DEFAULT NULL,
                remember_token VARCHAR(255) DEFAULT NULL, 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";

        if ($conn->query($createUsersTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'users' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }

        // Insert a default admin user (for testing purposes)
        $adminName = 'Admin';
        $adminEmail = 'admin@admin.com';
        $adminPassword = password_hash('admin', PASSWORD_DEFAULT); // Hash the password
        $adminRole = 'admin';
        $adminEmailConfirmed = true;

        $insertAdminUserQuery = $conn->prepare("
            INSERT INTO users (name, email, password, role, email_confirmed) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $insertAdminUserQuery->bind_param("ssssi", $adminName, $adminEmail, $adminPassword, $adminRole, $adminEmailConfirmed);

        if ($insertAdminUserQuery->execute()) {
            echo PHP_EOL . "Default admin user inserted successfully.";
        } else {
            throw new Exception("Error inserting admin user: " . $insertAdminUserQuery->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);



