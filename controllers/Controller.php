<?php

class Controller
{
    public function __construct()
    {
        global $conn;
        $path = __DIR__ . '/../config/db_connection.php';
        require_once $path;
    }

    protected function loadView ($viewName, $data = []): void
    {
        extract($data);

        $filePath = __DIR__ . '/../views/' . $viewName . '.php';

        if (!file_exists($filePath)) {
            echo "File not found: " . $filePath;
            die;
        }
        require_once $filePath;
    }
}