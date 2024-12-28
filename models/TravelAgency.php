<?php

class TravelAgency extends Model
{
    private const KEYS = ['name', 'description', 'address', 'phone', 'email', 'website'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "agencies", TravelAgency::KEYS);
    }
}