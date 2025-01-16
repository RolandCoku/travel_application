<?php

class AuthMiddleware {

    private User $user;

    public function __construct()
    {
        global $conn;
        $this->user = new User($conn);
    }

    public function handle(): void
    {
        session_start();

        if (!isset($_SESSION['user_email']) && isset($_COOKIE['remember_me'])) {
            $user = $this->user->getUserByRememberToken($_COOKIE['remember_me']);
            if ($user) {
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
            }
        }

        // Set timeout duration (15 minutes)
        $sessionTimeout = 15 * 60;

        // Check if the session is set and validate its lifetime
        if (isset($_SESSION['last_activity'])) {
            if (time() - $_SESSION['last_activity'] > $sessionTimeout) {
                // Session expired
                session_unset();
                session_destroy();
                header("Location: /login");
                exit;
            }
        }

        // Update the last activity timestamp
        $_SESSION['last_activity'] = time();

        // Protecting a page
        if (!isset($_SESSION['user_email'])) {
            header("Location: /login");
            exit;
        }
    }
}

