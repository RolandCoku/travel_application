<?php

class TravelPackageBookings
{
  // public readonly ?int $id;
  // private int $booking_id;
  // private int $travel_package_id;
  // private readonly ?DateTime $created_at;
  // private ?DateTime $updated_at;
 
  public function __construct(
    public readonly ?int $id, 
    public int $booking_id, 
    public int $travel_package_id, 
    public readonly ?DateTime $created_at, 
    public readonly ?DateTime $updated_at
  ){
  }

  public static function dtos(int $booking_id, int $travel_package_id): self  // don't think I'm actually gonna use this
  {
    return new TravelPackageBookings(null, $booking_id, $travel_package_id, null, null);
  }

  public static function fromAssocArray(array $obj): self
  {
    foreach( ["id", "booking_id", "travel_package_id", "created_at", "updated_at"] as $key){
      if(!array_key_exists($key, $obj))
        return null;
    } // I should think of a better error-handling methodic
    return new TravelPackageBookings(
      $obj['id'],
      $obj['booking_id'],
      $obj['travel_package_id'],
      $obj['created_at'],
      $obj['updated_at']
    );
  }

}