<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Township
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getAllTownships()
    {
        $sql = "SELECT * FROM township WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTownshipById($id)
    {
        $sql = "SELECT * FROM township WHERE id = :id AND (status IS NULL OR status != 'deleted')";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }
}
