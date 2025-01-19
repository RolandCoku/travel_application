<?php

require_once __DIR__ . '/Model.php';


class Booking extends Model
{
  // these are the keys that are needed during creation and can be modified later, others are automatically generated
  private const KEYS = ['user_id', 'travel_package_id', 'booking_date', 'booking_status'];

  public function __construct(mysqli $conn)
  {
    parent::__construct($conn, "bookings", Booking::KEYS);
  }


  // We create the booking and then proceed to create the payment
  public function create($obj): bool
  {
    require_once __DIR__ . '/Payment.php';

    if (!parent::create(
      [
        'user_id' => $obj['user_id'],
        // 'agency_id' => $obj['agency_id'],
        'travel_package_id' => $obj['travel_package_id'],
        'booking_date' => $obj['booking_date'],
        'booking_status' => 'pending',
      ]
    )) {
      return false;
    }

    $bookingId = $this->conn->insert_id;

    $payment = [
      'booking_id' => $bookingId,
      'payment_date' => $obj['booking_date'],
      'payment_method' => $obj['payment_method'],
      'amount' => $obj['total_price'],
      'payment_status' => 'pending'
    ];

    $paymentModel = new Payment($this->conn);

    if (!$paymentModel->create($payment)) {
      return false;
    }
    return true;
  }

  public function getTopDestinations($limit = 3, ?int $agency_id = null): false|mysqli_result
  {
    $query = "SELECT travel_packages.name, COUNT(bookings.id) AS bookings
        FROM bookings
        JOIN travel_packages ON bookings.travel_package_id = travel_packages.id";

    $whereClause = "";
    $orderByClause = " GROUP BY travel_packages.name ORDER BY bookings DESC";
    $limitClause = " LIMIT ?";

    $bindParams = [];
    $bindTypes = "";

    if ($agency_id) {
        $whereClause = " WHERE travel_packages.agency_id = ?";
        $bindParams[] = $agency_id;
        $bindTypes .= "i";
    }

    $query .= $whereClause . $orderByClause . $limitClause;
    $bindParams[] = $limit;
    $bindTypes .= "i";

    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        error_log("Error preparing statement: " . $this->conn->error);
        return false;
    }

    if (!empty($bindParams)) {
        $stmt->bind_param($bindTypes, ...$bindParams);
    }

    if (!$stmt->execute()) {
        error_log("Error executing query: " . $stmt->error);
        return false;
    }

    return $stmt->get_result();
  }

  public function paginate(int $page, int $limit, array $keys = ['*'], ?int $agencyId = null): array
  {
    $offset = ($page - 1) * $limit;

    $aliasedKeys = array_map(function ($key) {
      // Replace the dot (.) with an underscore (_) to create an alias for the column to avoid ambiguity
      return "$key AS " . str_replace('.', '_', $key);
    }, $keys);

    $aliasedKeysString = implode(', ', $aliasedKeys);

    $query = "SELECT $aliasedKeysString FROM $this->table
                JOIN users ON bookings.user_id = users.id
                JOIN travel_packages ON bookings.travel_package_id = travel_packages.id";

    if ($agencyId !== null) {
      $query .= " JOIN payments ON payments.booking_id=bookings.id 
        WHERE travel_packages.agency_id = ?";
    } else {
      $query .= " JOIN agencies ON travel_packages.agency_id = agencies.id";
    }

    $query .= " LIMIT ? OFFSET ?";

    $stmt = $this->conn->prepare($query);

    $bindParams = [];

    if ($agencyId !== null) {
      $bindParams[] = $agencyId;
    }

    $bindParams[] = $limit;
    $bindParams[] = $offset;


    $stmt->bind_param(str_repeat('i', count($bindParams)), ...$bindParams);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

    // Set the current page and the total number of pages
    $currentPage = $page;
    $totalPages = ceil($this->conn->query("SELECT COUNT(*) FROM bookings" . ($agencyId !== null ? "
    JOIN travel_packages ON bookings.travel_package_id = travel_packages.id
    WHERE travel_packages.agency_id = $agencyId" : ""))->fetch_row()[0] / $limit);

    return [
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
      'data' => $data
    ];
  }

  public function getByDateRangeForAgency($startDate, $endDate, $agency_id): array
  {
    $queryString = "SELECT * FROM bookings
    JOIN travel_packages ON bookings.travel_package_id=travel_packages.id
    WHERE created_at BETWEEN ? AND ?
    AND travel_packages.agency_id = ?;
    ";

    $getQuery = $this->conn->prepare("$queryString");

    $getQuery->bind_param('ssi', $startDate, $endDate, $agency_id);
    $getQuery->execute();
    $result = $getQuery->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
      $data[$row['id']] = $row;
    }

    return $data;
  }
}
