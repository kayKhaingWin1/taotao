<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Order
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

public function createOrder($orderCode, $total, $date, $time, $userId, $townshipId)
{
    $this->conn = Database::connect();
    $sql = "INSERT INTO `order`(order_code, total_price, date, time, user_id, township_id) 
            VALUES(:order_code, :total, :date, :time, :user_id, :township_id)";
    $this->statement = $this->conn->prepare($sql);
    $this->statement->bindParam(':order_code', $orderCode);
    $this->statement->bindParam(':total', $total);
    $this->statement->bindParam(':date', $date);
    $this->statement->bindParam(':time', $time);
    $this->statement->bindParam(':user_id', $userId);
    $this->statement->bindParam(':township_id', $townshipId);
    
    if ($this->statement->execute()) {
        return $this->conn->lastInsertId();
    }
    return false;
}

    public function getOrdersByUserId($user_id)
    {
        $sql = "SELECT * FROM `order` WHERE user_id = :user_id ORDER BY id DESC";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':user_id', $user_id);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
