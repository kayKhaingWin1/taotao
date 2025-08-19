<?php
include_once __DIR__ . '/../include/dbconfig.php';

class ProductSizeColor
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

  
    public function getByProductId($productId)
    {
        $sql = "SELECT psc.*, c.color AS color_name, s.size AS size_name
                FROM product_size_color psc
                JOIN color c ON psc.color_id = c.id
                JOIN size s ON psc.size_id = s.id
                WHERE psc.product_id = :product_id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute(['product_id' => $productId]);
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
