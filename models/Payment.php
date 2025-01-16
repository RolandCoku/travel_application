<?php

require_once __DIR__ . '/Model.php';

class Payment extends Model
{
  private const KEYS = ['booking_id', 'paypal_order_id', 'payment_date',/* 'payment_method',*/ 'amount', 'payment_status'];

  public function __construct(mysqli $conn)
  {
    parent::__construct($conn, "payments", Payment::KEYS);
  }

  public function setOrderId($paymentId, $paypalOrderId)
  {
    $updateQuery = $this->conn->prepare("UPDATE payments
                                               SET paypal_order_id=?
                                               WHERE id=?;
                                        ");

    $updateQuery->bind_param('si', $paypalOrderId, $paymentId);

    return $updateQuery->execute();
  }

  // public function completePayment($paymentId)
  // {
  //   // return parent::updateById($paymentId, ['payment_status' => 'approved']);
  //   $updateQuery = $this->conn->prepare("UPDATE payments
  //                                              SET payment_status=?
  //                                              WHERE id=?;
  //                                       ");

  //   $updateQuery->bind_param('si', 'approved', $paymentId);
  //   return $updateQuery->execute();
  // }
}
