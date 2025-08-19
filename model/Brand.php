<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Brand
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getBrands()
    {
        $sql = "SELECT * FROM brand WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getBrand($id)
{
    $sql = "SELECT * FROM brand WHERE id = :id AND (status IS NULL OR status != 'deleted')";
    $this->statement = $this->conn->prepare($sql);
    $this->statement->bindParam(':id', $id);
    $this->statement->execute();
    return $this->statement->fetch(PDO::FETCH_ASSOC);
}

}
