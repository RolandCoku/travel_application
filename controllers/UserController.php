<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/EmailHelpers.php';

use JetBrains\PhpStorm\NoReturn;
use App\Helpers\EmailHelpers;

class UserController extends Controller
{
    private User $user;

    public function __construct()
    {
        global $conn;
        $this -> user = new User($conn);
    }

    public function login(): void
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

            if (!$this->user->isConfirmed($email)){

                $token = $this->user->getByEmail($email)['email_confirmation_token'];

                EmailHelpers::sendConfirmationEmail($email, $token);

                self::loadView('user/confirm_email');
                exit;
            }

            if ($this -> user -> authenticate($email, $password)) {
                $_SESSION['user_email'] = $email;
                //Check if the user is an admin
                $user = $this->user->getByEmail($email);
                if ($user['role'] === 'admin') {
                    header("Location: /admin/dashboard");
                } else
                    header("Location: /account-dashboard");
                exit;
            } else {
                echo "Invalid email or password";
                header("Location: /login");
            }
        }
    }

    public function register(): void
    {
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
            $email_confirmation_token = bin2hex(random_bytes(16));
            $role = 'user';

            if ($password !== $confirm_password) {
                echo "Passwords do not match";
                exit;
            }

            if ($this -> user -> emailExists($email)) {
                echo "Email already exists";
                exit;
            }

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
                'email_confirmed' => 0,
                'email_confirmation_token' => $email_confirmation_token
            ];

            if ($this -> user -> create($data)) {
                echo "User created successfully";
                header("Location: /login");
            } else {
                echo "Failed to create user";
            }
        }
    }

    #[NoReturn] public function logout(): void
    {
        session_start();
        session_destroy();
        header("Location: /login");
        exit;
    }

    public function accountDashboard(): void
    {
        self::loadView('user/account-dashboard');
    }

    public function adminDashboard($page = 1): void
    {
        $users = $this->user->paginate($page, 5);

        self::loadView('admin/index', ['users' => $users['data'], 'page' => $users['currentPage'], 'totalPages' => $users['totalPages']]);
    }

    public function confirmEmail(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $token = $_GET['token'] ?? null;

            $user = $this->user->findByConfirmationToken($token);

            if (!$user) {
                echo "Invalid or expired token.";
                exit;
            }

            $this->user->confirmEmail($user['email']);

            //Should add a success message here later
            header("Location: /login");
            exit;
        }
    }


}