<?php

require_once __DIR__ . '/Model.php';

class Payment extends Model
{
    private const KEYS = ['booking_id', 'payment_date', 'payment_method', 'amount', 'payment_status'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "payments", Payment::KEYS);
    }

}