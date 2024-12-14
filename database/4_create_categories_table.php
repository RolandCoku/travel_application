<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the categories table if it exists
        $dropCategoriesTableQuery = "DROP TABLE IF EXISTS categories";

        if ($conn->query($dropCategoriesTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'categories' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the categories table
        $createCategoriesTableQuery = "
            CREATE TABLE categories (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL UNIQUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";

        if ($conn->query($createCategoriesTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'categories' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);
