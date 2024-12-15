<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../config/db_connection.php';


class UserController extends Controller
{
    public static function login(): void
    {
        session_start();

        if (isset($_SESSION['user_email'])) {
            header("Location: /account-dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::loadView('user/login');

        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'] ?? '';

            //Filter email and password for security purposes to prevent SQL injection
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Check if email and password are correct
            if (self::authenticate($email, $password)) {
                $_SESSION['user_email'] = $email;
                header("Location: /account-dashboard");
                exit;
            } else {
                echo "Invalid email or password";
            }

        }
    }

    public static function register(): void
    {
        if (isset($_SESSION['user_email'])) {
            header("Location: /account-dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::loadView('user/register');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
        }
    }

    public static function logout(): void
    {
        session_start();
        session_destroy();
        header("Location: /login");
        exit;
    }

    public static function accountDashboard(): void
    {
        self::loadView('user/account-dashboard');
    }

    public static function adminDashboard(): void
    {
        self::loadView('admin/dashboard');
    }

    private static function authenticate($email, $password): bool
    {
        global $conn;

        // Prepare SQL query to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        //User not found
        if ($result->num_rows === 0) {
            return false;
        }

        // Get user details
        $user = $result->fetch_assoc();

        // Verify password
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return true;
    }

}