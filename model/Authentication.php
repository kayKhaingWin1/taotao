<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Authentication {
    private $conn, $statement;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function createUser($name, $email, $password) {
        try {
            $sql = 'INSERT INTO "user" (name, email, password) VALUES (:name, :email, :password)';
            $this->statement = $this->conn->prepare($sql);
            $this->statement->bindParam(':name', $name);
            $this->statement->bindParam(':email', $email);
            $this->statement->bindParam(':password', $password);
            return $this->statement->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function createUserAndGetId($name, $email, $password) {
    try {
        $sql = 'INSERT INTO "user" (name, email, password) VALUES (:name, :email, :password) RETURNING id';
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':email', $email);
        $this->statement->bindParam(':password', $password);
        
        if ($this->statement->execute()) {
            $result = $this->statement->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        }
        return false;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

    public function getUsers() {
        $sql = 'SELECT * FROM "user"';
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUser($id) {
        $sql = 'SELECT * FROM "user" WHERE id = :id';
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email) {
        $sql = 'SELECT * FROM "user" WHERE email = :email LIMIT 1';
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':email', $email);
        $this->statement->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $name = null, $email = null, $password = null, $address = null, $phone = null) {
        $updates = [];
        $params = [':id' => $id];

        if ($name !== null) {
            $updates[] = "name = :name";
            $params[':name'] = $name;
        }
        if ($email !== null) {
            $updates[] = "email = :email";
            $params[':email'] = $email;
        }
        if ($password !== null) {
            $updates[] = "password = :password";
            $params[':password'] = $password;
        }
        if ($address !== null) {
            $updates[] = "address = :address";
            $params[':address'] = $address;
        }
        if ($phone !== null) {
            $updates[] = "phone = :phone";
            $params[':phone'] = $phone;
        }

        if (empty($updates)) {
            return false;
        }

        $sql = 'UPDATE "user" SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $this->statement = $this->conn->prepare($sql);
        return $this->statement->execute($params);
    }
}
?>