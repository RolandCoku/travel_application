<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../models/User.php';


class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        global $conn;
        $this->user = new User($conn);
    }

    public static function login(): void
    {
        global $conn;
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

            $user = new User($conn);
            if ($user->authenticate($email, $password)) {
                $_SESSION['user_email'] = $email;
                header("Location: /account-dashboard");
                exit;
            } else {
                echo "Invalid email or password";
                header("Location: /login");
            }
        }
    }

    public static function register(): void
    {
        global $conn;
        if (isset($_SESSION['user_email'])) {
            header("Location: /account-dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::loadView('user/register');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] . ' ' . $_POST['surname'];
            $email = $_POST['email'];
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $role = 'user';

            if ($password !== $confirm_password) {
                echo "Passwords do not match";
                exit;
            }

            $user = new User($conn);

            if ($user->emailExists($email)) {
                echo "Email already exists";
                exit;
            }

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
                'email_confirmed' => 1
            ];

            if ($user->create($data)) {
                echo "User created successfully";
                header("Location: /login");
            } else {
                echo "Failed to create user";
            }
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
}