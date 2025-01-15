<?php

class LoginAttempt extends Model
{
    private const KEYS = ['user_id', 'failed_attempts', 'lockout_time'];

    public function __construct(mysqli $conn)
    {
        parent::__construct($conn, "login_attempts", LoginAttempt::KEYS);
    }

    public function incrementFailedAttempts($user_id): void
    {
        $loginAttempt = $this->getByUserId($user_id);

        if ($loginAttempt) {
            $loginAttempt['failed_attempts']++;
            $this->update($loginAttempt);
        } else {
            $this->create(['user_id' => $user_id, 'failed_attempts' => 1]);
        }
    }

    public function resetFailedAttempts($user_id): void
    {
        $loginAttempt = $this->getByUserId($user_id);

        if ($loginAttempt) {
            $loginAttempt['failed_attempts'] = 0;
            $this->update($loginAttempt);
        }
    }

    public function lockout($user_id): void
    {
        $loginAttempt = $this->getByUserId($user_id);

        if ($loginAttempt) {
            $loginAttempt['lockout_time'] = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $this->update($loginAttempt);
        } else {
            $this->create(['user_id' => $user_id, 'lockout_time' => date('Y-m-d H:i:s', strtotime('+5 minutes'))]);
        }
    }

    public function isLockedOut($user_id): bool
    {
        $loginAttempt = $this->getByUserId($user_id);

        if ($loginAttempt) {
            return strtotime($loginAttempt['lockout_time']) > time();
        }

        return false;
    }

    public function resetLockout($user_id): void
    {
        $loginAttempt = $this->getByUserId($user_id);

        if ($loginAttempt) {
            $loginAttempt['lockout_time'] = null;
            $this->update($loginAttempt);
        }
    }

    public function getByUserId($user_id): false|array|null
    {
        $sql_select = "SELECT * FROM login_attempts WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql_select);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}