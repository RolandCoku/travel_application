<?php

class TravelAgency extends Model
{
    private const KEYS = ['user_id', 'name', 'description', 'address', 'phone', 'website'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "agencies", TravelAgency::KEYS);
    }

    public function create($obj): bool|string
    {
        $agencyData = [
            'user_id' => $obj['user_id'],
            'name' => $obj['name'],
            'description' => $obj['description'],
            'address' => $obj['address'],
            'phone' => $obj['phone'],
            'website' => $obj['website'],
        ];

        if (parent::create($agencyData) === false) {
            return false;
        }

        $agencyId = $this->conn->insert_id;

        // Handle main image
        $image = $_FILES['main_image'];
        $imageName = FileHelpers::uploadImage($image);

        $imageData = [
            'entity_type' => 'agency',
            'entity_id' => $agencyId,
            'image_url' => $imageName,
            'alt_text' => $obj['name'],
            'type' => 'main',
        ];

        $imageModel = new Image($this->conn);
        $imageModel->create($imageData);

        // Handle secondary images
        if (isset($_FILES['secondary_images']) && is_array($_FILES['secondary_images']['name'])) {
            foreach ($_FILES['secondary_images']['name'] as $index => $secondaryName) {
                // Prepare secondary image data
                $secondaryImage = [
                    'name' => $_FILES['secondary_images']['name'][$index],
                    'type' => $_FILES['secondary_images']['type'][$index],
                    'tmp_name' => $_FILES['secondary_images']['tmp_name'][$index],
                    'error' => $_FILES['secondary_images']['error'][$index],
                    'size' => $_FILES['secondary_images']['size'][$index],
                ];

                if ($secondaryImage['error'] === UPLOAD_ERR_OK) {
                    // Upload secondary image
                    $secondaryImageName = FileHelpers::uploadImage($secondaryImage);

                    $secondaryImageData = [
                        'entity_type' => 'agency',
                        'entity_id' => $agencyId,
                        'image_url' => $secondaryImageName,
                        'alt_text' => $obj['name'],
                        'type' => 'secondary',
                    ];

                    // Save secondary image data
                    $imageModel->create($secondaryImageData);
                }
            }
        }

        return true;
    }

    public function paginate(int $page, int $limit, array $keys): array
    {

        if (!empty($keys)) {
            $keys = implode(", ", $keys);
        } else {
            $keys = "*";
        }

        $offset = ($page - 1) * $limit;

        $queryString = "SELECT $keys FROM agencies
                        JOIN users ON agencies.user_id = users.id
                        LIMIT ? OFFSET ?;
                        ";

        $getQuery = $this->conn->prepare("$queryString");

        $getQuery->bind_param('ii', $limit, $offset);
        $getQuery->execute();

        $result = $getQuery->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[$row['name']] = $row;
        }

        //Set the current page and the total number of pages
        $currentPage = $page;
        $totalPages = ceil($this->conn->query("SELECT COUNT(*) FROM agencies")->fetch_row()[0] / $limit);

        return [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'data' => $data
        ];

    }

    public function getTopAgencies($limit): array
    {

        // Get the top 5 travel agencies with the most bookings based on the travel packages booked
        $queryString = "SELECT agencies.name, COUNT(bookings.id) as bookings
                        FROM agencies
                        JOIN travel_packages ON agencies.id = travel_packages.agency_id
                        JOIN bookings ON travel_packages.id = bookings.travel_package_id
                        GROUP BY agencies.name
                        ORDER BY bookings DESC
                        LIMIT ?;
                        ";

        $getQuery = $this->conn->prepare("$queryString");

        $getQuery->bind_param('i', $limit);

        $getQuery->execute();
        $result = $getQuery->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[$row['name']] = $row;
        }

        return $data;
    }



}