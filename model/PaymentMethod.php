<?php
include_once __DIR__ . '/../include/dbconfig.php';

class PaymentMethod
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getActiveMethods()
    {
        $sql = "SELECT * FROM payment_method WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }


}
