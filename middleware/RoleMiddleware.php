<?php
class RoleMiddleware {
    public static function handle($requiredRole): void
    {
        if (!isset($_SESSION['user_email'])) {
            header("Location: /login");
            exit;
        }

        global $conn;
        require_once implode(DIRECTORY_SEPARATOR, [ __DIR__ , '..', 'models', 'User.php']);
        $user = new User($conn);
        $user = $user->getByEmail($_SESSION['user_email']);

//        if ($user['role'] !== $requiredRole) {
//            redirect('/login', ['error' => 'Unauthorized access'], 'login');
//        }
    }
}
