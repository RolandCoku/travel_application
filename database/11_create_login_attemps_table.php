<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the login_attempts table if it exists
        $dropLoginAttemptsTableQuery = "DROP TABLE IF EXISTS login_attempts";

        if ($conn->query($dropLoginAttemptsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'login_attempts' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the login_attempts table
        $createLoginAttemptsTableQuery = "
            CREATE TABLE login_attempts (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(6) UNSIGNED NOT NULL,
                failed_attempts INT(6) UNSIGNED NOT NULL DEFAULT 0,
                lockout_time TIMESTAMP NULL DEFAULT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ";

        if ($conn->query($createLoginAttemptsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'login_attempts' created successfully.";
        } else {
            echo PHP_EOL . "Error creating table: " . $conn->error;
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);