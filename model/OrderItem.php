<?php
include_once __DIR__ . '/../include/dbconfig.php';

class OrderItem
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function createOrderItem($quantity, $price, $product_id, $order_id)
    {
        $sql = "INSERT INTO order_item (quantity, price, product_id, order_id)
                VALUES (:quantity, :price, :product_id, :order_id)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':quantity', $quantity);
        $this->statement->bindParam(':price', $price);
        $this->statement->bindParam(':product_id', $product_id);
        $this->statement->bindParam(':order_id', $order_id);
        return $this->statement->execute();
    }

    public function getItemsByOrderId($order_id)
    {
        $sql = "SELECT * FROM order_item WHERE order_id = :order_id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':order_id', $order_id);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
