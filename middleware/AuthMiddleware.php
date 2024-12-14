<?php

class AuthMiddleware {
    public static function handle(): void
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }
}

