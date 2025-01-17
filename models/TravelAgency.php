<?php

class TravelAgency extends Model
{
    private const KEYS = ['user_id', 'name', 'description', 'address', 'phone', 'website'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "agencies", TravelAgency::KEYS);
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