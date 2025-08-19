<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Size
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getSizes()
    {
        $sql = "SELECT * FROM size WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
   
   public function getSizesByProductId($productId) {
    $sql = "SELECT DISTINCT s.* FROM size s
            JOIN product_size_color psc ON s.id = psc.size_id
            WHERE psc.product_id = :product_id
            ORDER BY FIELD(s.size, 'XS', 'S', 'M', 'L', 'XL', 'XXL')";
    $this->statement = $this->conn->prepare($sql);
    $this->statement->bindParam(':product_id', $productId);
    $this->statement->execute();
    return $this->statement->fetchAll(PDO::FETCH_ASSOC);
}

}
