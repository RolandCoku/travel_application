<?php

require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Image.php';
require_once __DIR__ . '/../helpers/FileHelpers.php';

class TravelPackage extends Model
{
    private const KEYS = ['name', 'description', 'price', 'start_date', 'end_date', 'agency_id'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "travel_packages", TravelPackage::KEYS);
    }

    //Create the travel package and after that create the image associated with it
    public function create($obj): bool|string
    {
        if (parent::create($obj) === false) {
            return false;
        }

        $travelPackageId = $this->conn->insert_id;

        $image = $_FILES['image'];

        $imageName = FileHelpers::uploadImage($image);

        $imageData = [
            'travel_package_id' => $travelPackageId,
            'image_url' => $imageName,
            'alt_text' => $obj['name'],
            'type' => 'main'
        ];

        $imageModel = new Image($this->conn);
        $imageModel->create($imageData);

        return true;
    }


    //Has many method for reviews
    public function reviews(): array
    {
        $sql = "SELECT * FROM reviews WHERE travel_package_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $this['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $reviews;
    }

    //Has many method for images
    public function images($id): array
    {
        $sql = "SELECT * FROM images WHERE travel_package_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $images;
    }

    //Belongs to method for agency
    public function agency(): array
    {
        $sql = "SELECT * FROM agencies WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $this['agency_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $agency = $result->fetch_assoc();
        $stmt->close();

        return $agency;
    }
}