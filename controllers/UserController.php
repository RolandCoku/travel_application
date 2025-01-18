<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/EmailHelpers.php';
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/../models/LoginAttempt.php';

use JetBrains\PhpStorm\NoReturn;
use App\Helpers\EmailHelpers;

class UserController extends Controller
{
    private User $user;
    private Log $log;
    private LoginAttempt $loginAttempt;

    public function __construct()
    {
        global $conn;
        $this->user = new User($conn);
        $this->log = new Log($conn);
        $this->loginAttempt = new LoginAttempt($conn);
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_email'])) {
            redirect('/account-dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::loadView('user/login');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $rememberMe = isset($_POST['remember-me']);

            // Check if the user is locked out
            $user = $this->user->getByEmail($email);
            if ($this->loginAttempt->isLockedOut($user['id'])) {
                //Get the time remaining until the lockout is lifted
                $minutesRemaining = $this->loginAttempt->getMinutesRemaining($user['id']);
                redirect('/login', ['error' => 'You are locked out. Please try again in ' . $minutesRemaining . ' minutes.'], 'login');
            }

            if (!$this->user->emailExists($email)) {
                redirect('/login', ['error' => 'Invalid email or password'], 'login');
            }

            if (!$this->user->isConfirmed($email)) {
                $token = $this->user->getByEmail($email)['email_confirmation_token'];
                EmailHelpers::sendConfirmationEmail($email, $token);
                $this->log->log($this->user->getByEmail($email)['id'], 'Email confirmation sent');
                redirect('confirm-email?email=' . $email);
            }

            if ($this->user->authenticate($email, $password)) {
                $_SESSION['user_email'] = $email;
                $_SESSION['user_id'] = $this->user->getByEmail($email)['id'];

                // Reset the failed login attempts
                $this->loginAttempt->resetFailedAttempts($this->user->getByEmail($email)['id']);

                // Reset the lockout
                $this->loginAttempt->resetLockout($this->user->getByEmail($email)['id']);

                // Handle Remember Me
                if ($rememberMe) {
                    $token = bin2hex(random_bytes(16));
                    $this->user->setRememberMeToken($email, $token);

                    setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
                }

                $this->log->log($this->user->getByEmail($email)['id'], 'Login');

                // Redirect based on user role
                $user = $this->user->getByEmail($email);
                redirect($user['role'] === 'admin' ? '/admin/dashboard' : '/account-dashboard');
            } else {
                if ($this->user->emailExists($email)) {
                    $this->log->log($this->user->getByEmail($email)['id'], 'Login failed');

                    // Increment the failed login attempts
                    $this->loginAttempt->incrementFailedAttempts($this->user->getByEmail($email)['id']);
                }
                redirect('/login', ['error' => 'Invalid email or password'], 'login');
            }
        }
    }

    public function register(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_email'])) {
            redirect('/account-dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::loadView('user/register');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] . ' ' . $_POST['surname'];
            $email = $_POST['email'];
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $emailConfirmationToken = bin2hex(random_bytes(16));
            $role = 'user';

            if (strlen($_POST['name']) < 2) {
                redirect('/register', ['name_error' => 'Name must be at least 2 characters long'], 'register');
            }

            if (strlen($_POST['surname']) < 2) {
                redirect('/register', ['surname_error' => 'Surname must be at least 2 characters long'], 'register');
            }

            $emailRegex = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
            if (!preg_match($emailRegex, $email)) {
                redirect('/register', ['email_error' => 'Invalid email address'], 'register');
            }

            if ($password !== $confirmPassword) {
                redirect('/register', ['confirm_password_error' => 'Passwords do not match'], 'register');
            }

            if ($this->user->emailExists($email)) {
                redirect('/register', ['email_error' => 'Email already exists'], 'register');
            }

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
                'email_confirmed' => 0,
                'email_confirmation_token' => $emailConfirmationToken
            ];

            if ($this->user->create($data)) {
                $this->log->log($this->user->getByEmail($email)['id'], 'User created');

                EmailHelpers::sendConfirmationEmail($email, $emailConfirmationToken);
                redirect('/confirm-email?email=' . $email);
            } else {
                $this->log->log($this->user->getByEmail($email)['id'], 'User creation failed');
                redirect('/register', ['error' => 'User creation failed. Please try again.'], 'register');
            }
        }
    }

    #[NoReturn] public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();

        // Clear the Remember Me cookie
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);

        // Invalidate the token in the database
        $userEmail = $_SESSION['user_email'] ?? null;
        if ($userEmail) {
            $this->user->clearRememberMeToken($userEmail);
        }

        redirect('/login');
    }

    public function confirmEmail(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? null;

            $user = $this->user->findByConfirmationToken($token);

            if (!$user) {
                redirect('/login', ['error' => 'Invalid or expired confirmation token.'], 'login');
            }

            $this->user->confirmEmail($user['email']);
            $this->log->log($user['id'], 'Email confirmed');
            redirect('/login', ['success' => 'Email confirmed successfully. Please login to your account!'], 'login');

        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $email = $_GET['email'] ?? null;
            self::loadView('user/confirm_email', ['email' => $email]);
        }
    }

    public function forgotPassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::loadView('user/forgot-password');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;

            if (!$this->user->emailExists($email)) {
                redirect('/forgot-password', ['error' => 'Email not found'], 'forgot-password');
            }

            $token = bin2hex(random_bytes(16));
            $this->user->setPasswordResetToken($email, $token);

            EmailHelpers::sendPasswordResetEmail($email, $token);
            $this->log->log($this->user->getByEmail($email)['id'], 'Password reset email sent');

            self::loadView('user/password-reset-email-sent', ['email' => $email]);
        }
    }

    public function resetPassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $token = $_GET['token'] ?? null;
            $email = $_GET['email'] ?? null;

            if (!$this->user->findByPasswordResetToken($token)) {
                redirect('/forgot-password', ['error' => 'Invalid or expired password reset token.'], 'forgot-password');
            }
            self::loadView('user/reset_password', ['email' => $email]);

        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $newPassword = $_POST['new_password'] ?? null;
            $confirmPassword = $_POST['confirm_password'] ?? null;

            if ($newPassword !== $confirmPassword) {
                redirect('/reset-password?email=' . $email, ['error' => 'Passwords do not match'], 'reset-password');
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $this->user->resetPassword($email, $hashedPassword);
            $this->user->clearPasswordResetToken($email);
            $this->log->log($this->user->getByEmail($email)['id'], 'Password reset');

            redirect('/login', ['success' => 'Password reset successfully. Please login to your account!'], 'login');
        }
    }

    public function accountDashboard(): void
    {
        $user = $this->user->getByEmail($_SESSION['user_email']);
        self::loadView('user/account-dashboard', ['user' => $user]);
    }

    // API endpoints
    #[NoReturn] public function paginateUsers(): void
    {
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;
        $users = $this->user->paginate($page, $limit, ['id', 'name', 'email', 'role', 'email_confirmed']);
        header('Content-Type: application/json');
        echo json_encode($users);
        exit;
    }

    #[NoReturn] public function getUsersByRegisteredDateRange(): void
    {
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;
        $users = $this->user->getByDateRange($startDate, $endDate);
        header('Content-Type: application/json');
        echo json_encode($users);
        exit;
    }

    #[NoReturn] public function countUsersByRegisteredDateRange(): void
    {
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;
        $nrUsers = $this->user->countByDateRange($startDate, $endDate);
        header('Content-Type: application/json');
        echo json_encode($nrUsers);
        exit;
    }

    #[NoReturn] public function searchUsers(): void
    {
        $searchQuery = $_GET['search_query'] ?? null;
        $limit = $_GET['limit'] ?? 10;
        $offset = $_GET['offset'] ?? 0;

        $result = $this->user->search($searchQuery, $limit, $offset, ['id', 'name', 'email', 'role']);

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($users);
        exit;
    }

}
