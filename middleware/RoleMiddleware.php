<?php
class RoleMiddleware {
    public static function handle($requiredRole): void
    {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $requiredRole) {
            http_response_code(403);
            echo "Access denied: insufficient permissions.";
            exit;
        }
    }
}
