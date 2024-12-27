<?php
require_once 'Model.php';

class User extends Model
{

    private const KEYS = ['name', 'email', 'password', 'role', 'email_confirmed'];

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

        return $result->fetch_assoc();
    }

    public function comfirmEmail(mixed $email)
    {
        $sql_update = "UPDATE users SET email_confirmed = 1 WHERE email = ?";

        $stmt = $this->conn->prepare($sql_update);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    }

}