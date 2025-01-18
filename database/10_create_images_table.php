<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the images table if it exists
        $dropImagesTableQuery = "DROP TABLE IF EXISTS images";

        if ($conn->query($dropImagesTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'images' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the images table
        $createImagesTableQuery = "
            CREATE TABLE images (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                entity_type ENUM('agency', 'travel_package', 'user') NOT NULL, 
                entity_id INT(6) UNSIGNED NOT NULL,
                image_url VARCHAR(255) NOT NULL,
                alt_text VARCHAR(255) DEFAULT NULL, 
                type ENUM('main', 'secondary') DEFAULT 'secondary', 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
            );
        ";

        if ($conn->query($createImagesTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'images' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);