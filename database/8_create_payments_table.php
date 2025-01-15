<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{
    try {
        // Drop the payments table if it exists
        $dropPaymentsTableQuery = "DROP TABLE IF EXISTS payments";

        if ($conn->query($dropPaymentsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'payments' dropped successfully.";
        } else {
            throw new Exception("Error dropping table: " . $conn->error);
        }

        // Create the payments table
        $createPaymentsTableQuery = "
            CREATE TABLE payments (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                paypal_order_id VARCHAR(255) UNIQUE NULL,
                booking_id INT(6) UNSIGNED NOT NULL,
                amount DECIMAL(10, 2) NOT NULL,
                payment_date DATE NOT NULL,
                payment_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
            )
        ";

        if ($conn->query($createPaymentsTableQuery) === TRUE) {
            echo PHP_EOL . "Table 'payments' created successfully.";
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }
    } catch (Exception $e) {
        echo PHP_EOL . "Migration failed: " . $e->getMessage();
    }
}

runMigration($conn);