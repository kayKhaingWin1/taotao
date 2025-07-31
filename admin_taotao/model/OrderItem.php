<?php
include_once __DIR__ . '/../include/dbconfig.php';

class OrderItem {
    private $conn, $stmt;

    public function getItemsByOrderId($order_id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT oi.*, p.name AS product_name, p.image AS product_image
                FROM order_item oi
                JOIN product p ON oi.product_id = p.id
                WHERE oi.order_id = :order_id";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderItem($id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT oi.*, p.name AS product_name 
                FROM order_item oi
                JOIN product p ON oi.product_id = p.id
                WHERE oi.id = :id";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}