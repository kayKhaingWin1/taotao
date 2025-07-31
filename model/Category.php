<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Category {
    private $conn, $statement;

    public function getcategories()
    {
        $this->conn = Database::connect();
         $sql = "SELECT * FROM category WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        if ($this->statement->execute()) {
            $results = $this->statement->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
    }
}

?>