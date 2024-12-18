<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the agencies table if it exists
        $dropAgenciesTableQuery = "DROP TABLE IF EXISTS agencies";

        if ($conn->query($dropAgenciesTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'agencies' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the agencies table
        $createAgenciesTableQuery = "
            CREATE TABLE agencies (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                email_confirmed BOOLEAN DEFAULT FALSE,
                phone VARCHAR(20) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";

        if ($conn->query($createAgenciesTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'agencies' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);
