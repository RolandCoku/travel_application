<?php
require_once __DIR__ . '\Repository.php';
require_once __DIR__ . '\..\models\TravelPackageBookings.php';

class TravelPackageBookingsRepository extends Repository{
  private static array $repKeys = ['id', 'booking_id','travel_package_id'];
  public function __construct(){
    parent::__construct("travel_package_bookings", $this->repKeys);
  }
  public function getById(int $id): TravelPackageBookings
  {
    return TravelPackageBookings::fromAssocArray(parent::getById($id));
  }
}