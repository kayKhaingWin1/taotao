<?php
include_once __DIR__ . '/../include/dbconfig.php';
include_once __DIR__ . '/../controller/PaymentMethodController.php';
class Payments
{
    private $conn, $statement;


public function createPayment($payment_method_id, $order_id)
{
    $sql = "INSERT INTO payments (pm_id, order_id, created_at) 
            VALUES (:pm_id, :order_id, NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':pm_id',$payment_method_id);
    $stmt->bindParam(':order_id', $order_id);

    return $stmt->execute();
}


 public function getPaymentMethod($method)
{
    $sql = "
        SELECT pm.id 
        FROM payment_method pm
        LEFT JOIN payment p ON p.pm_id = pm.id
        WHERE pm.method = :method
        LIMIT 1
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':method', $method);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['id'] : null;
}

}
