<?php
require_once __DIR__ . '/Model.php';

class Image extends Model
{
    private const KEYS = ['entity_type', 'entity_id', 'image_url', 'alt_text', 'type'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "images", Image::KEYS);
    }

    public function getImagesByEntity($entityType, $entityId): false|mysqli_result
    {
        $sql_select = "SELECT * FROM images WHERE entity_type = ? AND entity_id = ?";

        $stmt = $this->conn->prepare($sql_select);
        $stmt->bind_param("si", $entityType, $entityId);
        $stmt->execute();

        return $stmt->get_result();
    }
}
