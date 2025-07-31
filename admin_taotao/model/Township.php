<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Township {
    private $conn, $statement;

    public function getTownships()
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM township";
        $this->statement = $this->conn->prepare($sql);
        if ($this->statement->execute()) {
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getTownship($id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM township WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        if ($this->statement->execute()) {
            return $this->statement->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function addTownship($name, $fee)
    {
        $this->conn = Database::connect();
        $sql = "INSERT INTO township (name, fee) VALUES (:name, :fee)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':fee', $fee);
        return $this->statement->execute();
    }

    public function editTownship($id, $name, $fee)
    {
        $this->conn = Database::connect();
        $sql = "UPDATE township SET name = :name, fee = :fee WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':fee', $fee);
        return $this->statement->execute();
    }

    public function deleteTownship($id)
    {
        $this->conn = Database::connect();
        $sql = "DELETE FROM township WHERE id = :id"; 
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        return $this->statement->execute();
    }
}
