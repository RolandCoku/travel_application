<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the travel_package_bookings table if it exists
        $dropTravelPackageBookingsTableQuery = "DROP TABLE IF EXISTS travel_package_bookings";

        if ($conn->query($dropTravelPackageBookingsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'travel_package_bookings' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the travel_package_bookings table
        $createTravelPackageBookingsTableQuery = "
            CREATE TABLE travel_package_bookings (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                booking_id INT(6) UNSIGNED NOT NULL,
                travel_package_id INT(6) UNSIGNED NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
                FOREIGN KEY (travel_package_id) REFERENCES travel_packages(id) ON DELETE CASCADE
            )
        ";

        if ($conn->query($createTravelPackageBookingsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'travel_package_bookings' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);