<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Order
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

public function createOrder($orderCode, $total, $date, $time, $userId, $townshipId) {
    try {
        $this->conn->beginTransaction();
        
        $sql = 'INSERT INTO "order"
               (order_code, total_price, date, time, user_id, township_id) 
               VALUES 
               (:order_code, :total, :date, :time, :user_id, :township_id)';
        
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':order_code', $orderCode);
        $this->statement->bindParam(':total', $total); 
        $this->statement->bindParam(':date', $date);
        $this->statement->bindParam(':time', $time);
        $this->statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $this->statement->bindParam(':township_id', $townshipId, PDO::PARAM_INT);
        
        $this->statement->execute();
        $orderId = $this->conn->lastInsertId();
        
        $this->conn->commit();
        return $orderId;
        
    } catch (PDOException $e) {
        $this->conn->rollBack();
        error_log("Order creation failed: " . $e->getMessage());
        throw new Exception("Database error: " . $e->getMessage());
    }
}
    public function getOrdersByUserId($user_id)
    {
        try {
            $sql = 'SELECT * FROM "order" WHERE user_id = :user_id ORDER BY id DESC';
            $this->statement = $this->conn->prepare($sql);
            $this->statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $this->statement->execute();
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Get orders error: " . $e->getMessage());
            return [];
        }
    }
}