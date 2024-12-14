<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the travel_packages table if it exists
        $dropTravelPackagesTableQuery = "DROP TABLE IF EXISTS travel_packages";

        if ($conn->query($dropTravelPackagesTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'travel_packages' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the travel_packages table
        $createTravelPackagesTableQuery = "
            CREATE TABLE travel_packages (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                agency_id INT(6) UNSIGNED NOT NULL,
                name VARCHAR(50) NOT NULL,
                description TEXT NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                start_date DATE NOT NULL,
                end_date DATE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (agency_id) REFERENCES agencies(id) ON DELETE CASCADE
            )
        ";

        if ($conn->query($createTravelPackagesTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'travel_packages' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);
