<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';


function runMigration($conn): void
{
    try {
        // Drop the logs table if it exists
        $dropLogsTableQuery = "DROP TABLE IF EXISTS logs";

        if ($conn->query($dropLogsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'logs' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the logs table
        $createLogsTableQuery = "
            CREATE TABLE logs (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(6) UNSIGNED NOT NULL,
                action VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ";

        if ($conn->query($createLogsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'logs' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);
