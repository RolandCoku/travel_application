<?php

require_once __DIR__ . '/Model.php';

class Payment extends Model
{
  private const KEYS = ['booking_id', 'paypal_order_id', 'payment_date',/* 'payment_method',*/ 'amount', 'payment_status'];

  public function __construct(mysqli $conn)
  {
    parent::__construct($conn, "payments", Payment::KEYS);
  }

  public function createAndGetPaymentId(array $obj, int $travelPackageId): ?array
  {
    try {
      $this->conn->begin_transaction();

      // Booking Insertion (SQL)
      $bookingSql = "INSERT INTO bookings (user_id, travel_package_id, booking_date, booking_status, booked_seats) VALUES (?, ?, ?, 'pending', ?)";
      $bookingStmt = $this->conn->prepare($bookingSql);
      if (!$bookingStmt) {
        throw new Exception("Booking prepare statement failed: " . $this->conn->error);
      }
      $bookingStmt->bind_param("issi", $obj['user_id'], $obj['travel_package_id'], $obj['booking_date'], $obj['booked_seats']);
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
      $paymentStmt->bind_param("issd", $bookingId, $obj['booking_date'], $obj['paypal_order_id'], $obj['total_price']);
      if (!$paymentStmt->execute()) {
        throw new Exception("Payment execute statement failed: " . $paymentStmt->error);
      }
      $paymentId = $paymentStmt->insert_id;

      if ($paymentId === 0) {
        throw new Exception("Payment creation failed, no ID generated");
      }

      // Seats Update (SQL)
      $travelPackageSql = $travelPackageSql = "UPDATE travel_packages SET occupied_seats = occupied_seats + ? WHERE id = ? AND occupied_seats + ? <= seats";;
      $tpStmt = $this->conn->prepare($travelPackageSql);
      if (!$tpStmt) {
        throw new Exception("Payment prepare statement failed: " . $this->conn->error);
      }
      $tpStmt->bind_param("iii", $obj['booked_seats'], $travelPackageId, $obj['booked_seats']);
      if (!$tpStmt->execute()) {
        throw new Exception("Payment execute statement failed: " .  $tpStmt->error);
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
      if (isset($tpStmt)) {
        $tpStmt->close();
      }
    }
  }

  public function deleteAndReturnSeat(int $id): bool
  {
    try {
      $this->conn->begin_transaction();

      // Get travel_package_id (using FOR UPDATE to lock the row)
      $agencyQuery = $this->conn->prepare("SELECT travel_package_id, booked_seats FROM bookings WHERE id = ? FOR UPDATE");
      if (!$agencyQuery) {
        throw new Exception("Agency query prepare failed: " . $this->conn->error);
      }
      $agencyQuery->bind_param('i', $id);
      if (!$agencyQuery->execute()) {
        throw new Exception("Agency query execute failed: " . $agencyQuery->error);
      }
      $result = $agencyQuery->get_result()->fetch_assoc(); // Fetch associative array

      if ($result === null) {
        throw new Exception("Booking not found.");
      }
      $travelPackageId = $result['travel_package_id'];
      $returnSeats = $result['booked_seats'];

      error_log("travel package id to return seats is: " . $travelPackageId);

      if ($travelPackageId === null) {
        throw new Exception("Booking not found."); // Handle case where booking doesn't exist
      }

      // Delete booking
      $deleteQuery = $this->conn->prepare("DELETE FROM bookings WHERE id = ?");
      if (!$deleteQuery) {
        throw new Exception("Delete query prepare failed: " . $this->conn->error);
      }
      $deleteQuery->bind_param('i', $id);
      if (!$deleteQuery->execute()) {
        throw new Exception("Delete query execute failed: " . $deleteQuery->error);
      }

      // Seats Update
      $travelPackageSql = "UPDATE travel_packages SET occupied_seats = occupied_seats - ? WHERE id = ?";
      $tpStmt = $this->conn->prepare($travelPackageSql);
      if (!$tpStmt) {
        throw new Exception("Travel package update prepare failed: " . $this->conn->error);
      }
      $tpStmt->bind_param("ii", $returnSeats, $travelPackageId);
      if (!$tpStmt->execute()) {
        throw new Exception("Travel package update execute failed: " . $tpStmt->error);
      }

      $this->conn->commit();
      return true;
    } catch (Exception $e) {
      $this->conn->rollback();
      error_log("Transaction failed: " . $e->getMessage());
      return false;
    } finally {
      if (isset($agencyQuery))
        $agencyQuery->close();
      if (isset($deleteQuery))
        $deleteQuery->close();
      if (isset($tpStmt))
        $tpStmt->close();
      $this->conn->close();
    }
  }


  public function finishBooking(string $token): bool
  {
    try {
      $this->conn->begin_transaction();
      $findPaymentSql = "SELECT id, booking_id FROM payments WHERE paypal_order_id = ?";
      $findPaymentStmt = $this->conn->prepare($findPaymentSql);
      if (!$findPaymentStmt) {
        throw new Exception("Booking prepare statement failed: " . $this->conn->error);
      }
      $findPaymentStmt->bind_param("s", $token);
      if (!$findPaymentStmt->execute()) {
        throw new Exception("Booking execute statement failed: " . $findPaymentStmt->error);
      }
      $bookingIds = $findPaymentStmt->get_result()->fetch_assoc();

      // Booking Update (SQL)
      $bookingSql = "UPDATE bookings SET booking_status = 'approved' WHERE id = ?";
      $bookingStmt = $this->conn->prepare($bookingSql);
      if (!$bookingStmt) {
        throw new Exception("Booking prepare statement failed: " . $this->conn->error);
      }
      $bookingStmt->bind_param("i", $bookingIds['booking_id']);
      if (!$bookingStmt->execute()) {
        throw new Exception("Booking execute statement failed: " . $bookingStmt->error);
      }

      // Payment Update (SQL)
      $paymentSql = "UPDATE payments SET payment_status = 'approved' WHERE id = ?";
      $paymentStmt = $this->conn->prepare($paymentSql);
      if (!$paymentStmt) {
        throw new Exception("Payment prepare statement failed: " . $this->conn->error);
      }
      $paymentStmt->bind_param("i", $bookingIds['id']);
      if (!$paymentStmt->execute()) {
        throw new Exception("Payment execute statement failed: " . $paymentStmt->error);
      }

      $this->conn->commit();
      return true;
    } catch (Exception $e) {
      $this->conn->rollback();
      error_log("Finish booking transaction failed: " . $e->getMessage());
      return false;
    } finally {
      if (isset($findPaymentStmt)) {
        $findPaymentStmt->close();
      }
      if (isset($bookingStmt)) {
        $bookingStmt->close();
      }
      if (isset($paymentStmt)) {
        $paymentStmt->close();
      }
    }
  }

  public function getTotalPaymentsByDateRange(mixed $startDate, mixed $endDate)
  {
    $sql = "SELECT SUM(amount) as total FROM payments WHERE created_at BETWEEN ? AND ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();

    $result = $stmt->get_result();
    $total = $result->fetch_assoc();

    if (!$total['total']) {
      return 0;
    }

    return $total['total'];
  }
}
