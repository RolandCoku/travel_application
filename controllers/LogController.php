<?php

use JetBrains\PhpStorm\NoReturn;

class LogController extends Controller
{
    private Log $log;

    public function __construct()
    {
        global $conn;
        $this->log = new Log($conn);
    }

    #[NoReturn] public function getLatestLogsAndUserInfo(): void
    {
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 5;
        $result = $this->log->getLogs($page, $limit, ['action', 'logs.created_at'], ['name', 'email']);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'log' => [
                    'action' => $row['action'],
                    'created_at' => $row['created_at']
                ],
                'user' => [
                    'name' => $row['name'],
                    'email' => $row['email']
                ]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}