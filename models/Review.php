<?php

class Review extends Model
{
    private const KEYS = ['user_id', 'travel_package_id', 'comment', 'rating'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "reviews", Review::KEYS);
    }

    public function getReviewsByPackageId($id): array
    {
        $queryString = "SELECT * FROM reviews WHERE travel_package_id = ?";

        $getQuery = $this->conn->prepare("$queryString");
        $getQuery->bind_param('i', $id);
        $getQuery->execute();

        $result = $getQuery->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getAverageRatingByPackageId($id): float
    {
        $queryString = "SELECT AVG(rating) as average_rating FROM reviews WHERE travel_package_id = ?";

        $getQuery = $this->conn->prepare("$queryString");
        $getQuery->bind_param('i', $id);
        $getQuery->execute();

        $result = $getQuery->get_result();

        return $result->fetch_assoc()['average_rating'];
    }

    public function getReviewsByUserId($id): array
    {
        $queryString = "SELECT * FROM reviews WHERE user_id = ?";

        $getQuery = $this->conn->prepare("$queryString");
        $getQuery->bind_param('i', $id);
        $getQuery->execute();

        $result = $getQuery->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function paginate(int $page, int $limit, array $keys = ['*']): array
    {
        $offset = ($page - 1) * $limit;

        $aliasedKeys = array_map(function ($key) {
            // Replace the dot (.) with an underscore (_) to create an alias for the column to avoid ambiguity
            return "$key AS " . str_replace('.', '_', $key);
        }, $keys);

        $aliasedKeysString = implode(', ', $aliasedKeys);

        $query = "SELECT $aliasedKeysString FROM $this->table
                        JOIN users ON reviews.user_id = users.id
                        JOIN travel_packages ON reviews.travel_package_id = travel_packages.id
                        LIMIT ? OFFSET ?;
                        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();

        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        //Set the current page and the total number of pages
        $currentPage = $page;
        $totalPages = ceil($this->conn->query("SELECT COUNT(*) FROM reviews")->fetch_row()[0] / $limit);

        return [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'data' => $data
        ];
    }

    public function getLatestReviews($limit, $keys = ['*']): false|mysqli_result
    {

        $aliasedKeys = array_map(function ($key) {
            // Replace the dot (.) with an underscore (_) to create an alias for the column to avoid ambiguity
            return "$key AS " . str_replace('.', '_', $key);
        }, $keys);

        $aliasedKeysString = implode(', ', $aliasedKeys);

        $query = "SELECT $aliasedKeysString FROM reviews
                  JOIN users ON reviews.user_id = users.id
                  JOIN travel_packages ON reviews.travel_package_id = travel_packages.id
                  ORDER BY reviews.created_at DESC
                  LIMIT ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $limit);
        $stmt->execute();

        return $stmt->get_result();
    }

}