<?php
require_once __DIR__ . '\Repository.php';
require_once __DIR__ . '\..\models\Bookings.php';

class BookingsRepository extends Repository{
  private static array $repKeys = ['user_id', 'agency_id', 'travel_package_id', 'booking_date', 'booking_status']; //since this is repeated for every class
  public function __construct(){
    parent::__construct("bookings", BookingsRepository::$repKeys);
  }
  // public function getById(int $id): Booking
  // {
  //   return Booking::fromAssocArray(parent::getById($id));
  // }
}