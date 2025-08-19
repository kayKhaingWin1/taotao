<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Color
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getColors()
    {
        $sql = "SELECT * FROM color WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
public function getColorsByProductId($productId) {
    $sql = "SELECT DISTINCT c.* FROM color c
            JOIN product_size_color psc ON c.id = psc.color_id
            WHERE psc.product_id = :product_id";
    $this->statement = $this->conn->prepare($sql);
    $this->statement->bindParam(':product_id', $productId);
    $this->statement->execute();
    return $this->statement->fetchAll(PDO::FETCH_ASSOC);
}


}
