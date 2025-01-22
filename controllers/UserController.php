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
            if ($_SESSION['user_role'] === 'admin') {
                redirect('/admin/dashboard');
            } else if ($_SESSION['user_role'] === 'user') {
                redirect('/account-dashboard');
            } else if ($_SESSION['user_role'] === 'agency_admin') {
                redirect('/travel-agency/admin/dashboard');
            }
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
                $_SESSION['user_role'] = $this->user->getByEmail($email)['role'];

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

        // Clear the Remember Me cookie
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);

        // Invalidate the token in the database
        $userEmail = $_SESSION['user_email'] ?? null;
        if ($userEmail) {
            $this->user->clearRememberMeToken($userEmail);
        }

        session_unset();
        session_destroy();
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
            $this->user->clearEmailConfirmationToken($user['email']);
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
        global $conn;
        $user = $this->user->getByEmail($_SESSION['user_email']);
        $profilePicture = $this->user->profilePicture($user['id']) ?? [];
        $bookingResult = $this->user->bookings($user['id']);
        $reviewsResult = $this->user->reviews($user['id']);

        if (!empty($profilePicture)) {
            $profilePicture = [
                'image_url' => $profilePicture['image_url'],
                'alt_text' => $profilePicture['alt_text'],
            ];
        }

        $user = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'profile_picture' => $profilePicture,
        ];

        $bookings = [];
        while ($row = $bookingResult->fetch_assoc()) {
            $travelPackage = (new Booking($conn))->travelPackage($row['travel_package_id']);
            $travelPackageImg = (new TravelPackage($conn))->mainImage($row['travel_package_id']);
            $bookings[] = [
                'id' => $row['id'],
                'booking_date' => $row['booking_date'],
                'status' => $row['booking_status'],
                'travel_package' => [
                    'id' => $travelPackage['id'],
                    'name' => $travelPackage['name'],
                    'main_image' => $travelPackageImg,
                ],
            ];
        }

        $reviews = [];
        while ($row = $reviewsResult->fetch_assoc()) {
            $reviews[] = [
                'id' => $row['id'],
                'travel_package_id' => $row['travel_package_id'],
                'rating' => $row['rating'],
                'comment' => $row['comment'],
            ];
        }

        $user['bookings'] = $bookings;
        $user['reviews'] = $reviews;

        self::loadView('user/account-dashboard', ['user_profile_data' => $user]);
    }

    public function index(): void
    {
        self::loadView('user/index');
    }

    public function about(): void
    {
        self::loadView('user/about-us');
    }

    #[NoReturn] public function put(): void
    {
        $oldData = $this->user->getByEmail($_SESSION['user_email']);

        $name = $_POST['name'] ?? $oldData['name'];
        $email = $_POST['email'] ?? $oldData['email'];

        $data = [
            'name' => $name,
            'email' => $email
        ];

        $this->user->updateUserInfoById($oldData['id'], $data);
        $this->log->log($oldData['id'], 'Profile updated');

        $profilePicture = $_FILES['profile_picture'] ?? null;

        if ($profilePicture) {
            $imgName = FileHelpers::uploadImage($profilePicture);

            $this->user->updateProfilePicture($oldData['id'], $imgName);
        }

        redirect('/account-dashboard', ['success' => 'Profile updated successfully'], 'account-dashboard');
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

    public function changePassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $user = $this->user->getByEmail($_SESSION['user_email']);

            if (!password_verify($oldPassword, $user['password'])) {
                redirect('/user/change-password', ['error' => 'Invalid old password'], 'change-password');
            }

            if ($newPassword !== $confirmPassword) {
                redirect('/user/change-password', ['error' => 'Passwords do not match'], 'change-password');
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $this->user->resetPassword($user['email'], $hashedPassword);
            $this->log->log($user['id'], 'Password changed');

            redirect('/account-dashboard', ['success' => 'Password changed successfully'], 'account-dashboard');
        }
    }


}
