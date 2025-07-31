<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Order
{
    private $conn, $stmt;

    public function getOrdersWithStatus()
    {
        $this->conn = Database::connect();
        $sql = "SELECT o.*, u.name AS user_name, t.name AS township_name, 
                       COALESCE(p.status, 'Pending') AS payment_status
                FROM `order` o
                JOIN user u ON o.user_id = u.id
                JOIN township t ON o.township_id = t.id
                LEFT JOIN payment p ON o.id = p.order_id
                ORDER BY o.id DESC";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrder($id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT o.*, u.name AS user_name, t.name AS township_name, 
                   t.fee AS delivery_fee, COALESCE(p.status, 'Pending') AS payment_status
            FROM `order` o
            JOIN user u ON o.user_id = u.id
            JOIN township t ON o.township_id = t.id
            LEFT JOIN payment p ON o.id = p.order_id
            WHERE o.id = :id";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bindParam(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getOrderTotal($order_id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT SUM(quantity * price) AS total 
                FROM order_item 
                WHERE order_id = :order_id";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
