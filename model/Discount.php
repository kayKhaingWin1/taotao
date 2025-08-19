<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Discount {
    private $conn, $statement;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function getDiscountsByProductId($productId) {
        $sql = "SELECT d.*
                FROM discount d
                JOIN discount_product dp ON d.id = dp.discount_id
                WHERE dp.product_id = :product_id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':product_id', $productId);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
