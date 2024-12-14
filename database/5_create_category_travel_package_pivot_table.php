<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the pivot table if it exists
        $dropCategoryTravelPackagePivotTableQuery = "DROP TABLE IF EXISTS category_travel_package";

        if ($conn->query($dropCategoryTravelPackagePivotTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'category_travel_package' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the pivot table
        $createCategoryTravelPackagePivotTableQuery = "
            CREATE TABLE category_travel_package (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                category_id INT(6) UNSIGNED NOT NULL,
                travel_package_id INT(6) UNSIGNED NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
                FOREIGN KEY (travel_package_id) REFERENCES travel_packages(id) ON DELETE CASCADE
            )
        ";

        if ($conn->query($createCategoryTravelPackagePivotTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'category_travel_package' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);


