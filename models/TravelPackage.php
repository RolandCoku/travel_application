<?php

require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Image.php';
require_once __DIR__ . '/../helpers/FileHelpers.php';

class TravelPackage extends Model
{
    private const KEYS = ['name', 'description', 'location', 'price', 'start_date', 'end_date', 'agency_id'];

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
    public function reviews($id): false|mysqli_result
    {
        $sql = "SELECT * FROM reviews 
                LEFT JOIN users ON reviews.user_id = users.id
                WHERE travel_package_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    //Has many method for images
    public function secondaryImages($id): array
    {
        $sql = "SELECT * FROM images WHERE entity_id = ? AND entity_type = 'travel_package'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $images;
    }

    //Belongs to method for agency
    public function agency($id): false|mysqli_result
    {
        $sql = "SELECT * FROM agencies 
                LEFT JOIN users ON agencies.user_id = users.id
                WHERE agencies.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
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

    public function paginateForAgency(int $page, int $limit, int $agencyId, array $keys = []): array
{
    $offset = ($page - 1) * $limit;

    // Use the provided keys or default to the specified columns
    $columns = !empty($keys) ? implode(", ", $keys) : "
        travel_packages.id AS travel_packages_id,
        travel_packages.name AS travel_packages_name,
        travel_packages.description AS travel_packages_description,
        price,
        start_date,
        end_date,
        seats,
        occupied_seats
    ";

    $queryString = "SELECT $columns FROM travel_packages
                    JOIN agencies ON travel_packages.agency_id = agencies.id
                    WHERE travel_packages.agency_id = ?
                    LIMIT ? OFFSET ?;
                    ";

    $getQuery = $this->conn->prepare($queryString);

    $getQuery->bind_param('iii', $agencyId, $limit, $offset);

    $getQuery->execute();

    $result = $getQuery->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        // unset($row['travel_packages_id']); // Remove travel_packages_id from each row
        $data[] = $row;
    }


    $currentPage = $page;
    $totalPages = ceil($this->conn->query("SELECT COUNT(*) FROM travel_packages WHERE agency_id = $agencyId")->fetch_row()[0] / $limit);

    return [
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'data' => $data
    ];
}

    public function getTopPackages(int $limit, array $keys): array
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

    public function paginateWithImages(mixed $page, mixed $limit): false|mysqli_result
    {
        //Get packages with their main and secondary images
        $offset = ($page - 1) * $limit;


        $queryString = "SELECT tp.*, mi.image_url AS main_image_url,
                        mi.alt_text AS main_image_alt_text,
                        GROUP_CONCAT(si.image_url) AS secondary_image_urls,
                        GROUP_CONCAT(si.alt_text) AS secondary_image_alt_texts
                        FROM travel_packages tp
                        LEFT JOIN images mi 
                        ON tp.id = mi.entity_id 
                        AND mi.entity_type = 'travel_package' 
                        AND mi.type = 'main'
                        LEFT JOIN images si 
                        ON tp.id = si.entity_id 
                        AND si.entity_type = 'travel_package' 
                        AND si.type = 'secondary'
                        GROUP BY tp.id
                        LIMIT ? OFFSET ?;
                        ";

        $getQuery = $this->conn->prepare("$queryString");

        $getQuery->bind_param('ii', $limit, $offset);

        $getQuery->execute();

        return $getQuery->get_result();
    }

    public function getTotalPages(mixed $limit): int
    {
        $totalRows = $this->conn->query("SELECT COUNT(*) FROM $this->table")->fetch_row()[0];
        return ceil($totalRows / $limit);
    }

    public function getTopPackagesWithImagesPaginated(int $limit, int $page): false|mysqli_result
    {
        $offset = ($page - 1) * $limit;

        // SQL Query to fetch top travel packages with images and review data
        $queryString = "
                        SELECT
                            tp.*,
                            mi.image_url AS main_image_url,
                            mi.alt_text AS main_image_alt_text,
                            GROUP_CONCAT(DISTINCT si.image_url SEPARATOR ',') AS secondary_image_urls,
                            GROUP_CONCAT(DISTINCT si.alt_text SEPARATOR ',') AS secondary_image_alt_texts,
                            COUNT(DISTINCT r.id) AS total_reviews,
                            AVG(r.rating) AS average_rating
                        FROM
                            travel_packages tp
                                LEFT JOIN images mi
                                          ON tp.id = mi.entity_id
                                              AND mi.entity_type = 'travel_package'
                                              AND mi.type = 'main'
                                LEFT JOIN images si
                                          ON tp.id = si.entity_id
                                              AND si.entity_type = 'travel_package'
                                              AND si.type = 'secondary'
                                LEFT JOIN reviews r
                                          ON tp.id = r.travel_package_id
                        GROUP BY
                            tp.id
                        ORDER BY
                            total_reviews DESC,
                            average_rating DESC
                        LIMIT ? OFFSET ?;

        ";

        // Prepare the SQL statement
        $getQuery = $this->conn->prepare($queryString);

        if (!$getQuery) {
            // Handle prepare error
            die('Prepare failed: (' . $this->conn->errno . ') ' . $this->conn->error);
        }

        // Bind parameters: 'i' denotes two integers
        $getQuery->bind_param('ii', $limit, $offset);

        // Execute the query
        if (!$getQuery->execute()) {
            // Handle execute error
            die('Execute failed: (' . $getQuery->errno . ') ' . $getQuery->error);
        }

        // Get the result set
        return $getQuery->get_result();
    }

    public function getLatestPackagesWithImagesPaginated(mixed $limit, mixed $page): false|mysqli_result
    {
        $offset = ($page - 1) * $limit;

        $queryString = "SELECT tp.*, mi.image_url AS main_image_url,
                        mi.alt_text AS main_image_alt_text,
                        GROUP_CONCAT(si.image_url) AS secondary_image_urls,
                        GROUP_CONCAT(si.alt_text) AS secondary_image_alt_texts
                        FROM travel_packages tp
                        LEFT JOIN images mi 
                        ON tp.id = mi.entity_id 
                        AND mi.entity_type = 'travel_package' 
                        AND mi.type = 'main'
                        LEFT JOIN images si 
                        ON tp.id = si.entity_id 
                        AND si.entity_type = 'travel_package' 
                        AND si.type = 'secondary'
                        GROUP BY tp.id
                        ORDER BY tp.created_at DESC
                        LIMIT ? OFFSET ?;
                        ";

        $getQuery = $this->conn->prepare("$queryString");

        $getQuery->bind_param('ii', $limit, $offset);

        $getQuery->execute();

        return $getQuery->get_result();
    }

    public function getClosestPackagesWithImagesPaginated(mixed $limit, mixed $page): false|mysqli_result
    {
        $offset = ($page - 1) * $limit;

        $queryString = "SELECT tp.*, mi.image_url AS main_image_url,
                        mi.alt_text AS main_image_alt_text,
                        GROUP_CONCAT(si.image_url) AS secondary_image_urls,
                        GROUP_CONCAT(si.alt_text) AS secondary_image_alt_texts
                        FROM travel_packages tp
                        LEFT JOIN images mi 
                        ON tp.id = mi.entity_id 
                        AND mi.entity_type = 'travel_package' 
                        AND mi.type = 'main'
                        LEFT JOIN images si 
                        ON tp.id = si.entity_id 
                        AND si.entity_type = 'travel_package' 
                        AND si.type = 'secondary'
                        GROUP BY tp.id
                        ORDER BY ABS(DATEDIFF(tp.start_date, CURDATE()))
                        LIMIT ? OFFSET ?;
                        ";

        $getQuery = $this->conn->prepare("$queryString");

        $getQuery->bind_param('ii', $limit, $offset);

        $getQuery->execute();

        return $getQuery->get_result();
    }

    public function getByIdWithImages(mixed $id): false|mysqli_result
    {
        $queryString = "
                        SELECT 
                            tp.*, 
                            mi.image_url AS main_image_url,
                            mi.alt_text AS main_image_alt_text,
                            GROUP_CONCAT(DISTINCT si.image_url SEPARATOR ',') AS secondary_image_urls,
                            GROUP_CONCAT(DISTINCT si.alt_text SEPARATOR ',') AS secondary_image_alt_texts
                        FROM 
                            travel_packages tp
                        LEFT JOIN images mi 
                            ON tp.id = mi.entity_id 
                            AND mi.entity_type = 'travel_package' 
                            AND mi.type = 'main'
                        LEFT JOIN images si 
                            ON tp.id = si.entity_id 
                            AND si.entity_type = 'travel_package' 
                            AND si.type = 'secondary'
                        WHERE 
                            tp.id = ?
                        GROUP BY 
                            tp.id;
        ";

        $getQuery = $this->conn->prepare("$queryString");

        $getQuery->bind_param('i', $id);

        $getQuery->execute();

        return $getQuery->get_result();
    }


}