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
    $sql = "SELECT * FROM (
                SELECT DISTINCT s.* FROM size s
                JOIN product_size_color psc ON s.id = psc.size_id
                WHERE psc.product_id = :product_id
            ) AS distinct_sizes
            ORDER BY 
                CASE size
                    WHEN 'XS' THEN 1
                    WHEN 'S' THEN 2
                    WHEN 'M' THEN 3
                    WHEN 'L' THEN 4
                    WHEN 'XL' THEN 5
                    WHEN 'XXL' THEN 6
                    ELSE 7
                END";
     $this->statement = $this->conn->prepare($sql);
    $this->statement->bindParam(':product_id', $productId);
    $this->statement->execute();
    return $this->statement->fetchAll(PDO::FETCH_ASSOC);
}
}
