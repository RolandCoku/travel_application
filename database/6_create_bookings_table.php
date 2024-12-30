<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the bookings table if it exists
        $dropBookingsTableQuery = "DROP TABLE IF EXISTS bookings";

        if ($conn->query($dropBookingsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'bookings' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the bookings table
        $createBookingsTableQuery = "
            CREATE TABLE bookings (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(6) UNSIGNED NOT NULL,
                travel_package_id INT(6) UNSIGNED NOT NULL,
                booking_date DATE NOT NULL,
                booking_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (travel_package_id) REFERENCES travel_packages(id) ON DELETE CASCADE
            )
        ";

        if ($conn->query($createBookingsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'bookings' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);