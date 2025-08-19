<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Discount {
    private $conn, $statement;

    public function getDiscounts()
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM discount";
        $this->statement = $this->conn->prepare($sql);
        if ($this->statement->execute()) {
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getDiscount($id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM discount WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        if ($this->statement->execute()) {
            return $this->statement->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function addDiscount($discount, $voucher_code)
    {
        $this->conn = Database::connect();
        $sql = "INSERT INTO discount (discount, voucher_code) VALUES (:discount, :voucher_code)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':discount', $discount);
        $this->statement->bindParam(':voucher_code', $voucher_code);
        return $this->statement->execute();
    }

    public function editDiscount($id, $discount, $voucher_code)
    {
        $this->conn = Database::connect();
        $sql = "UPDATE discount SET discount = :discount, voucher_code = :voucher_code WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->bindParam(':discount', $discount);
        $this->statement->bindParam(':voucher_code', $voucher_code);
        return $this->statement->execute();
    }

    public function deleteDiscount($id)
    {
        $this->conn = Database::connect();
        $sql = "DELETE FROM discount WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        return $this->statement->execute();
    }

    public function getLastInsertedId()
    {
        return $this->conn->lastInsertId();
    }
}
