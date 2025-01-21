<?php

global $conn;

require_once __DIR__ . '/../config/db_connection.php';

function runMigration($conn): void
{

  if ($conn->connect_error) {
    throw new Exception("Connection failed: " . $conn->connect_error);
  }

  $eventSql = "
        CREATE EVENT IF NOT EXISTS return_unapproved_seats_event
        ON SCHEDULE EVERY 1 HOUR
        STARTS CURRENT_TIMESTAMP
        DO
        BEGIN
            START TRANSACTION;

            UPDATE travel_packages tp
            INNER JOIN bookings b ON tp.id = b.travel_package_id
            SET tp.occupied_seats = tp.occupied_seats - b.booked_seats
            WHERE b.booking_status = 'pending' AND b.created_at < NOW() - INTERVAL 1 HOUR;

            DELETE b
            FROM bookings b
            WHERE b.booking_status = 'pending' AND b.created_at < NOW() - INTERVAL 1 HOUR;

            COMMIT;
        END
    ";

  if ($conn->multi_query($eventSql)) {
    do {
      if ($result = $conn->store_result()) {
        $result->free();
      }
    } while ($conn->more_results() && $conn->next_result()); // Corrected loop condition

    echo "MySQL event created (or already exists) successfully.\n";
  } else {
    throw new Exception("Error creating MySQL event: " . $conn->error);
  }

  $result = $conn->query("SHOW VARIABLES LIKE 'event_scheduler'");
    if (!$result) {
        throw new Exception("Error checking event_scheduler: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    $result->free_result(); // Free the result set

    if (strtoupper($row['Value']) != 'ON') {
        // Attempt to enable the event scheduler
        if ($conn->query("SET GLOBAL event_scheduler = ON")) {
            echo "Event scheduler enabled successfully.\n";

            // Verify that the event scheduler is now running
            $result = $conn->query("SHOW VARIABLES LIKE 'event_scheduler'");
            if (!$result) {
                throw new Exception("Error checking event_scheduler after setting it: " . $conn->error);
            }
            $row = $result->fetch_assoc();
            $result->free_result();
            if (strtoupper($row['Value']) != 'ON') {
                throw new Exception("Failed to verify event scheduler is ON. Check MySQL logs.");
            }
        } else {
            throw new Exception("Failed to enable event scheduler: " . $conn->error . ". Ensure the user has SUPER privileges.");
        }
    } else {
        echo "Event scheduler is already enabled.\n";
    }
  
  $conn->close();
}

runMigration($conn);