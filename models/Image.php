<?php
require_once __DIR__ . '/Model.php';

class Image extends Model
{
    private const KEYS = ['travel_package_id', 'image_url', 'alt_text', 'type'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "images", Image::KEYS);
    }

}