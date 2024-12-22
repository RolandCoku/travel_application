<?php
require_once 'Booking.php';

global $conn;
if(!isset($conn)){
  require_once implode(DIRECTORY_SEPARATOR, [ __DIR__ , '..', 'config', 'db_connection.php']);
}

$booking = new Booking($conn);
echo $booking->updateById(11, ['user_id'=>32, 'agency_id'=> 2]);
echo $booking->update(['id'=>2, 'user_id'=> 3, 'agency_id' => 21]);
echo $booking->create(['user_id'=>21, 'agency_id'=>11, 'travel_package_id'=>23, 'booking_date'=>'2024-12-21', 'booking_status'=>'pending']);