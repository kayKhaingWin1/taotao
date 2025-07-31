<?php
include_once __DIR__ . '/../include/dbconfig.php';

class PaymentMethod {
    private $conn, $statement;

    public function getPaymentMethods() {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM payment_method";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaymentMethod($id) {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM payment_method WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function addPaymentMethod($method) {
        $this->conn = Database::connect();
        $sql = "INSERT INTO payment_method (method) VALUES (:method)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':method', $method);
        return $this->statement->execute();
    }

    public function editPaymentMethod($id, $method) {
        $this->conn = Database::connect();
        $sql = "UPDATE payment_method SET method = :method WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->bindParam(':method', $method);
        return $this->statement->execute();
    }

    public function deletePaymentMethod($id) {
        $this->conn = Database::connect();
        $sql = "DELETE FROM payment_method WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        return $this->statement->execute();
    }
}
