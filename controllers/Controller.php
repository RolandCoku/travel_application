<?php

class Controller
{

    protected static function loadView ($viewName, $data = []): void
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