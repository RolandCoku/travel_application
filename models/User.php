<?php
require_once 'Model.php';

class User extends Model
{

    private const KEYS = ['name', 'email', 'password', 'role', 'email_confirmed', 'email_confirmation_token'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "users", User::KEYS);
    }

    public function authenticate($email, $password): bool
    {
        // Prepare SQL query to prevent SQL injection
        $sql_select = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql_select);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return true;
        }

        return false;
    }

    public function emailExists($email): bool
    {
        $sql_select = "SELECT * FROM users WHERE email = ?";

        $stmt = $this->conn->prepare($sql_select);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function isConfirmed($email): bool
    {
        $user = $this->getByEmail($email);

        return $user['email_confirmed'] === 1;
    }

    public function getByEmail($email): array
    {
        $sql_select = "SELECT * FROM users WHERE email = ?";

        $stmt = $this->conn->prepare($sql_select);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return [];
        }

        return $result->fetch_assoc();
    }

    public function confirmEmail(mixed $email): void
    {
        $sql_update = "UPDATE users SET email_confirmed = 1 WHERE email = ?";

        $stmt = $this->conn->prepare($sql_update);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    }

    public function findByConfirmationToken($token): false|array|null
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email_confirmation_token = ?");
        $stmt->bind_param('s', $token);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return false;
        }

        return $result->fetch_assoc();
    }

    public function setRememberMeToken($email, $token): void
    {
        $sql_update = "UPDATE users SET remember_token = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql_update);

        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
    }

    public function getUserByRememberToken($token): array
    {
        $sql_select = "SELECT * FROM users WHERE remember_token = ?";

        $stmt = $this->conn->prepare($sql_select);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return [];
        }

        return $result->fetch_assoc();
    }

    public function clearRememberMeToken(mixed $userEmail): void
    {
        $sql_update = "UPDATE users SET remember_token = NULL WHERE email = ?";
        $stmt = $this->conn->prepare($sql_update);
        $stmt->bind_param("s", $userEmail);
        $stmt->execute();
    }

    public function setPasswordResetToken(mixed $email, string $token): void
    {
        $sql_update = "UPDATE users SET password_reset_token = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql_update);
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
    }

    public function findByPasswordResetToken(mixed $token): false|array|null
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE password_reset_token = ?");
        $stmt->bind_param('s', $token);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return false;
        }

        return $result->fetch_assoc();
    }

    public function resetPassword(mixed $email, mixed $newPassword): void
    {
        $sql_update = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql_update);
        $stmt->bind_param("ss", $newPassword, $email);
        $stmt->execute();
    }

    public function clearPasswordResetToken(mixed $email): void
    {
        $sql_update = "UPDATE users SET password_reset_token = NULL WHERE email = ?";
        $stmt = $this->conn->prepare($sql_update);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    }

    public function search(mixed $searchQuery, int $limit, int $offset, array $keys): false|mysqli_result
    {
        $columns = implode(',', $keys);

        $sql_search = "SELECT $columns FROM users WHERE name LIKE ? OR email LIKE ? LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql_search);
        $searchQuery = "%$searchQuery%";
        $stmt->bind_param("ssii", $searchQuery, $searchQuery, $limit, $offset);

        $stmt->execute();

        return $stmt->get_result();
    }
}