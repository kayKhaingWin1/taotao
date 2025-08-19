<?php
include_once __DIR__ . '/../include/dbconfig.php';

class ColorSize {
    private $conn, $statement;

    public function getColors() {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM color WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSizes() {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM size WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItem($type, $id) {
        $this->conn = Database::connect();
        $table = $type === 'color' ? 'color' : 'size';
        $sql = "SELECT * FROM $table WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function addItem($type, $value, $code = null)
{
    $this->conn = Database::connect();

    if ($type === 'color') {
        if ($code === null) {
            throw new Exception("Color code is required.");
        }

        $sql = "INSERT INTO color (color, color_code) VALUES (:value, :code)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':value', $value);
        $this->statement->bindParam(':code', $code);
    } else {
        $sql = "INSERT INTO size (size) VALUES (:value)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':value', $value);
    }

    return $this->statement->execute();
}

   
    public function updateItem($type, $id, $value, $code = null) {
        $this->conn = Database::connect();
        if ($type === 'color') {
            $sql = "UPDATE color SET color = :value, color_code = :code WHERE id = :id";
            $this->statement = $this->conn->prepare($sql);
            $this->statement->bindParam(':value', $value);
            $this->statement->bindParam(':code', $code);
        } else {
            $sql = "UPDATE size SET size = :value WHERE id = :id";
            $this->statement = $this->conn->prepare($sql);
            $this->statement->bindParam(':value', $value);
        }
        $this->statement->bindParam(':id', $id);
        return $this->statement->execute();
    }

   
    public function deleteItem($type, $id) {
        $this->conn = Database::connect();
        $table = $type === 'color' ? 'color' : 'size';
        $sql = "UPDATE $table SET status = 'deleted' WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        return $this->statement->execute();
    }
}
