<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Payment {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function createPayment($order_id, $pm_id) {
      
        $status = $this->determinePaymentStatus($pm_id);
        
        $sql = "INSERT INTO payment (order_id, pm_id, status) 
                VALUES (:order_id, :pm_id, :status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':pm_id', $pm_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        
        return $stmt->execute() ? $this->conn->lastInsertId() : false;
    }

    public function getPaymentByOrder($order_id) {
        $sql = "SELECT p.*, pm.method as payment_method 
                FROM payment p
                JOIN payment_method pm ON p.pm_id = pm.id
                WHERE p.order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePaymentStatus($payment_id, $status) {
        $sql = "UPDATE payment SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        return $stmt->execute();
    }

    private function determinePaymentStatus($pm_id) {
       
        $pmController = new PaymentMethodController();
        $paymentMethod = $pmController->getPaymentMethod($pm_id);
        
       
        if (stripos($paymentMethod['method'], 'Pay later') !== false) {
            return 'Unpaid';
        }
        return 'Paid';
    }

public function getAllPaymentsWithDetails() {
    $this->conn = Database::connect();
    $sql = "SELECT p.*, pm.method as payment_method, o.date
            FROM payment p
            JOIN payment_method pm ON p.pm_id = pm.id
            JOIN `order` o ON p.order_id = o.id
            ORDER BY p.id DESC";
   $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}