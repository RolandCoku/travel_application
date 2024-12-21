<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create($data)
    {
        $sql_insert = "INSERT INTO users (name, email, password, role , email_confirmed) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql_insert);

        $stmt->bind_param("sssss", $data['name'], $data['email'], $data['password'], $data['role'], $data['email_confirmed']);

        return $stmt->execute();
    }

    public function getAll()
    {
        $sql_select = "SELECT * FROM users";

        $result = $this->conn->query($sql_select);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $sql_select = "SELECT * FROM users WHERE id = ?";

        $stmt = $this->conn->prepare($sql_select);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function update($data)
    {
        $sql_update = "UPDATE users SET name = ?, email = ?, password = ?, role = ?, email_confirmed = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql_update);

        $stmt->bind_param("sssssi", $data['name'], $data['email'], $data['password'], $data['role'], $data['email_confirmed'], $data['id']);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql_delete = "DELETE FROM users WHERE id = ?";

        $stmt = $this->conn->prepare($sql_delete);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function authenticate($email, $password): bool
    {
        //Check if the email is confirmed
        $stmt = $this->conn->prepare("SELECT email_confirmed FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user['email_confirmed']) {
            return false;
        }

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
}