<?php
require_once 'Booking.php';

global $conn;
if(!isset($conn)){
  require_once implode(DIRECTORY_SEPARATOR, [ __DIR__ , '..', 'config', 'db_connection.php']);
}

$booking = new Booking($conn);
echo $booking->updateById(11, ['user_id'=>32, 'agency_id'=> 2]);