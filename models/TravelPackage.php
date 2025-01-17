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

    public function paginate(int $page, int $limit, array $keys = ['*']): array
    {
        $offset = ($page - 1) * $limit;

        $aliasedKeys = array_map(function ($key) {
            // Replace the dot (.) with an underscore (_) to create an alias for the column to avoid ambiguity
            return "$key AS " . str_replace('.', '_', $key);
        }, $keys);

        $columns = implode(", ", $aliasedKeys);

        $queryString = "SELECT $columns FROM travel_packages
                        JOIN agencies ON travel_packages.agency_id = agencies.id
                        LIMIT ? OFFSET ?;
                        ";

        $getQuery = $this->conn->prepare("$queryString");

        $getQuery->bind_param('ii', $limit, $offset);

        $getQuery->execute();

        $result = $getQuery->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[$row['travel_packages_id']]['id'] = $row['travel_packages_id'];
            $data[$row['travel_packages_id']]['name'] = $row['travel_packages_name'];
            $data[$row['travel_packages_id']]['description'] = $row['travel_packages_description'];
            $data[$row['travel_packages_id']]['price'] = $row['price'];
            $data[$row['travel_packages_id']]['start_date'] = $row['start_date'];
            $data[$row['travel_packages_id']]['end_date'] = $row['end_date'];
            $data[$row['travel_packages_id']]['agency'] = $row['agencies_name'];
            $data[$row['travel_packages_id']]['free_seats'] = $row['seats'] - $row['occupied_seats'];
        }

        //Set the current page and the total number of pages
        $currentPage = $page;
        $totalPages = ceil($this->conn->query("SELECT COUNT(*) FROM $this->table")->fetch_row()[0] / $limit);

        return [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'data' => $data
        ];
    }

    public function getTopPackages(int $limit, array $keys)
    {

        $aliasKeys = array_map(function ($key) {
            return "$key AS " . str_replace('.', '_', $key);
        }, $keys);

        $columns = implode(", ", $aliasKeys);

        $queryString = "SELECT $columns, 
                       COUNT(reviews.id) AS total_reviews, 
                       AVG(reviews.rating) AS average_rating
                FROM travel_packages
                LEFT JOIN reviews ON travel_packages.id = reviews.travel_package_id
                GROUP BY travel_packages.id
                ORDER BY total_reviews DESC, average_rating DESC
                LIMIT ?;";


        $getQuery = $this->conn->prepare("$queryString");

        $getQuery->bind_param('i', $limit);
        $getQuery->execute();

        $result = $getQuery->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'name' => $row['travel_packages_name'],
                'total_reviews' => $row['total_reviews'],
                'average_rating' => floor($row['average_rating'])
            ];
        }

        return $data;
    }
}