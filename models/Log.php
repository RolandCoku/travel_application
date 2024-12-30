<?php

class Log extends Model
{
    private const KEYS = ['user_id', 'action', 'created_at'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "logs", Log::KEYS);
    }

    public function log($user_id, $action): void
    {
        $sql_insert = "INSERT INTO logs (user_id, action) VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql_insert);

        $stmt->bind_param("is", $user_id, $action);

        $stmt->execute();
    }

    public function getLogs($page): array
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $sql_select = "SELECT logs.id, users.name, logs.action, logs.created_at FROM logs JOIN users ON logs.user_id = users.id ORDER BY logs.created_at DESC LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql_select);

        $stmt->bind_param("ii", $limit, $offset);

        $stmt->execute();

        $result = $stmt->get_result();

        $logs = [];

        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }

        return $logs;
    }
}