<?php
include_once __DIR__ . '/../include/dbconfig.php';

class User {
    private $conn, $stmt;

    public function getUser($id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM user WHERE id = :id";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM user ORDER BY name ASC";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM user WHERE email = :email";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}