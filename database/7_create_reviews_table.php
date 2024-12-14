<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the reviews table if it exists
        $dropReviewsTableQuery = "DROP TABLE IF EXISTS reviews";

        if ($conn->query($dropReviewsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'reviews' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the reviews table
        $createReviewsTableQuery = "
            CREATE TABLE reviews (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(6) UNSIGNED NOT NULL,
                travel_package_id INT(6) UNSIGNED NOT NULL,
                rating ENUM('1', '2', '3', '4', '5') NOT NULL,
                comment TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (travel_package_id) REFERENCES travel_packages(id) ON DELETE CASCADE
            )
        ";

        if ($conn->query($createReviewsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'reviews' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);