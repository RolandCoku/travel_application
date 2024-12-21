<?php

enum BookingStatus
{
  case pending;
  case approved;
  case rejected;
}

class Booking
{
  // public int $id;
  // public int $user_id;
  // public int $agency_id;
  // public int $travel_package_id;
  // public DateTime $booking_date;
  // public BookingStatus $booking_status;
  // public DateTime $created_at;
  // public DateTime $updated_at;
  
  public function __construct(
    public ?int $id, 
    public int $user_id,
    public int $agency_id,
    public int $travel_package_id,
    public DateTime $booking_date,
    public BookingStatus $booking_status, 
    public ?DateTime $created_at, 
    public ?DateTime $updated_at
  ) {}

  public static function dtos(int $user_id, int $agency_id, int $travel_package_id, DateTime $booking_date, BookingStatus $booking_status): self  // don't think I'm actually gonna use this
  {
    return new Booking(null, $user_id, $agency_id, $travel_package_id, $booking_date, $booking_status, null, null);
  }

  public static function fromAssocArray(array $obj): self
  {
    // $class_fields = array_keys(get_class_vars('Booking'));  // this will have all, cause
    foreach( ["id","user_id", "agency_id", "travel_package_id","booking_date","booking_status", "created_at", "updated_at"] as $key){
      if(!array_key_exists($key, $obj))
        return null;
    } // I should think of a better error-handling methodic
    // $intersection = array_intersect_key($obj, $class_fields); // I gotta check if this actually works
    // if(count($intersection) !== count($class_fields))
    //   return null;
    return new Booking(
      $obj['id'],
      $obj['user_id'],
      $obj['agency_id'],
      $obj['travel_package_id'],
      $obj['booking_date'],
      $obj['booking_status'],
      $obj['created_at'],
      $obj['updated_at']
    );

  }
}