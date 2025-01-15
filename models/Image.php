<?php
require_once __DIR__ . '/Model.php';

class Image extends Model
{
  private const KEYS = ['travel_package_id', 'image_url', 'alt_text', 'type'];

  public function __construct(mysqli $conn)
  {
    parent::__construct($conn, "images", Image::KEYS);
  }

  public function getByTravelPackageId($travelPackageId)
  {
    $queryString = "SELECT * FROM images WHERE travel_package_id=?;";


    $getQuery = $this->conn->prepare("$queryString");

    $getQuery->bind_param('i', $travelPackageId);
    $getQuery->execute();
    $result = $getQuery->get_result();

    return $result->fetch_assoc();
  }
}
