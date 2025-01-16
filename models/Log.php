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

    public function getLogs($page, $limit, $logKeys, $userKeys): false|mysqli_result
    {
        $offset = ($page - 1) * $limit;

        if (isset($logKeys) && isset($userKeys)) {
            $logColumns = implode(", ", $logKeys);
            $logColumns = "logs.id, $logColumns";
            $userColumns = implode(", ", $userKeys);
            $userColumns = "users.id, $userColumns";
            $sql_select = "SELECT $logColumns, $userColumns FROM logs
                           JOIN users ON logs.user_id = users.id
                           ORDER BY logs.created_at DESC
                           LIMIT ? OFFSET ?";
        } else if (isset($logKeys)) {
            $columns = implode(", ", $logKeys);
            $columns = "user.id, $columns";
            $sql_select = "SELECT $columns FROM logs
                           ORDER BY created_at DESC
                           LIMIT ? OFFSET ?";
        } else {
            $sql_select = "SELECT * FROM logs
                           ORDER BY created_at DESC
                           LIMIT ? OFFSET ?";
        }

        $stmt = $this->conn->prepare($sql_select);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();

        return $stmt->get_result();
    }
}