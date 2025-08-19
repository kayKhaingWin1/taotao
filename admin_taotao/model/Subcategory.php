<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Subcategory
{
    private $conn, $statement;

    public function getSubcategories()
    {
        $this->conn = Database::connect();
        $status = 'deleted';
        $sql = "SELECT subcategory.*, category.name AS category_name
            FROM subcategory
            JOIN category ON subcategory.cat_id = category.id
            WHERE subcategory.status IS NULL OR subcategory.status != :status";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':status', $status);
        if ($this->statement->execute()) {
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }


    public function addSubcategory($name, $image, $cat_id)
    {
        $this->conn = Database::connect();
        $sql = "INSERT INTO subcategory (name, image, cat_id) VALUES (:name, :image, :cat_id)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':image', $image);
        $this->statement->bindParam(':cat_id', $cat_id);
        return $this->statement->execute();
    }

    public function getSubcategory($id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM subcategory WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        if ($this->statement->execute()) {
            return $this->statement->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function editSubcategory($id, $name, $image, $cat_id)
    {
        $this->conn = Database::connect();
        $sql = "UPDATE subcategory SET name = :name, image = :image, cat_id = :cat_id WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':image', $image);
        $this->statement->bindParam(':cat_id', $cat_id);
        return $this->statement->execute();
    }

    public function deleteSubcategory($id)
    {
        $status = 'deleted';
        $this->conn = Database::connect();
        $sql = "UPDATE subcategory SET status = :status WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':status', $status);
        $this->statement->bindParam(':id', $id);
        return $this->statement->execute();
    }
}
