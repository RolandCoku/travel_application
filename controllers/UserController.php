<?php

require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../models/User.php';

use JetBrains\PhpStorm\NoReturn;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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
                self::confirmEmail($email);
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
                'email_confirmed' => 1
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

    private function confirmEmail($email): void
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['GMAIL_USERNAME'];
            $mail->Password = $_ENV['GMAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('rolandcoku1@gmail.com', 'Roland Coku');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Email Confirmation';
            $mail->Body = 'Click <a href="http://localhost:8000/confirm-email?email=' . $email . '">here</a> to confirm your email';

            $mail->send();
            echo 'Email has been sent';
            exit;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

}