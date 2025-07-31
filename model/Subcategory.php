<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Subcategory {
    private $conn, $statement;

    public function getSubcategories() {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM subcategory WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        if ($this->statement->execute()) {
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getSubcategoriesByCategoryId($categoryId) {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM subcategory WHERE cat_id = :cat_id AND (status IS NULL OR status != 'deleted')";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':cat_id', $categoryId, PDO::PARAM_INT);
        if ($this->statement->execute()) {
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
?>
