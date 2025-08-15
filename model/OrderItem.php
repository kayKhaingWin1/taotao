<?php
include_once __DIR__ . '/../include/dbconfig.php';

class OrderItem
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function createOrderItem($quantity, $price, $productId, $orderId)
    {
        try {
            $sql = 'INSERT INTO "order_item" 
               (quantity, price, product_id, order_id) 
               VALUES 
               (:quantity, :price, :product_id, :order_id)';

            $this->statement = $this->conn->prepare($sql);
            $this->statement->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $this->statement->bindParam(':price', $price, PDO::PARAM_INT);
            $this->statement->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $this->statement->bindParam(':order_id', $orderId, PDO::PARAM_INT);

            return $this->statement->execute();
        } catch (PDOException $e) {
            error_log("OrderItem error: " . $e->getMessage());
            return false;
        }
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
