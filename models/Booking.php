<?php
require_once 'Model.php';

class Booking extends Model{
  // these are the keys that are needed during creation and can be modified later, others are automatically generated
  private const KEYS = ['user_id', 'agency_id', 'travel_package_id', 'booking_date', 'booking_status'];

  public function __construct(mysqli $conn){
    parent::__construct( $conn ,"bookings", Booking::KEYS);
  }
}