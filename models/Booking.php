<?php

require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Payment.php';


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

  public function createAndGetPaymentId(array $obj): ?array
  {
    try {
      $this->conn->begin_transaction();

      // Booking Insertion (SQL)
      $bookingSql = "INSERT INTO bookings (user_id, travel_package_id, booking_date, booking_status) VALUES (?, ?, ?, 'pending')";
      $bookingStmt = $this->conn->prepare($bookingSql);
      if (!$bookingStmt) {
        throw new Exception("Booking prepare statement failed: " . $this->conn->error);
      }
      $bookingStmt->bind_param("iis", $obj['user_id'], $obj['travel_package_id'], $obj['booking_date']);
      if (!$bookingStmt->execute()) {
        throw new Exception("Booking execute statement failed: " . $bookingStmt->error);
      }

      $bookingId = $bookingStmt->insert_id;

      if ($bookingId === 0) {
        throw new Exception("Booking creation failed, no ID generated");
      }

      // Payment Insertion (SQL)
      $paymentSql = "INSERT INTO payments (booking_id, payment_date, paypal_order_id, amount, payment_status) VALUES (?, ?, ?, ?, 'pending')";
      $paymentStmt = $this->conn->prepare($paymentSql);
      if (!$paymentStmt) {
        throw new Exception("Payment prepare statement failed: " . $this->conn->error);
      }
      $paymentStmt->bind_param("isdd", $bookingId, $obj['booking_date'], $obj['paypal_order_id'], $obj['total_price']);
      if (!$paymentStmt->execute()) {
        throw new Exception("Payment execute statement failed: " . $paymentStmt->error);
      }

      $paymentId = $paymentStmt->insert_id;

      if ($paymentId === 0) {
        throw new Exception("Payment creation failed, no ID generated");
      }

      $this->conn->commit();
      return [
        'paymentId' => $paymentId,
        'bookingId' => $bookingId,
      ];
    } catch (Exception $e) {
      $this->conn->rollback();
      error_log("Transaction failed: " . $e->getMessage());
      return null;
    } finally {
      if (isset($bookingStmt)) {
        $bookingStmt->close();
      }
      if (isset($paymentStmt)) {
        $paymentStmt->close();
      }
    }
  }


  public function finishBooking(int $bookingId, int $paymentId)
  {
    try {
      $this->conn->begin_transaction();

      if (!parent::updateById($bookingId, ['booking_status' => 'approved'])) {
        throw new Exception("Updating booking failed.");
      }

      $paymentModel = new Payment($this->conn);
      if (!$paymentModel->updateById($paymentId, ['payment_status' => 'approved'])) {
        throw new Exception("Updating payment failed.");
      }

      $this->conn->commit();
      return true;
    } catch (Exception $e) {
      $this->conn->rollback();
      error_log("Finish booking transaction failed: " . $e->getMessage()); // Log the error
      return false;
    }
  }

  public function getTopDestinations($limit = 3): false|mysqli_result
  {
    $query = "SELECT travel_packages.name, COUNT(bookings.id) as bookings
                  FROM bookings
                  JOIN travel_packages ON bookings.travel_package_id = travel_packages.id
                  GROUP BY travel_packages.name
                  ORDER BY bookings DESC
                  LIMIT ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i', $limit);
    $stmt->execute();

    return $stmt->get_result();
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
                        JOIN users ON bookings.user_id = users.id
                        JOIN travel_packages ON bookings.travel_package_id = travel_packages.id
                        JOIN agencies ON travel_packages.agency_id = agencies.id
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
    $totalPages = ceil($this->conn->query("SELECT COUNT(*) FROM bookings")->fetch_row()[0] / $limit);

    return [
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
      'data' => $data
    ];
  }
}
