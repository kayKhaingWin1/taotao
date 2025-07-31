<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Favourite
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function addFavourite($userId, $productId)
    {
        $sql = "INSERT INTO wishlist (user_id, product_id) VALUES (:user_id, :product_id)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':user_id', $userId);
        $this->statement->bindParam(':product_id', $productId);
        
        return $this->statement->execute();
    }

    public function removeFavourite($userId, $productId)
    {
        $sql = "DELETE FROM wishlist WHERE user_id = :user_id AND product_id = :product_id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':user_id', $userId);
        $this->statement->bindParam(':product_id', $productId);
        
        return $this->statement->execute();
    }

    public function isFavourite($userId, $productId)
    {
        $sql = "SELECT id FROM wishlist WHERE user_id = :user_id AND product_id = :product_id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':user_id', $userId);
        $this->statement->bindParam(':product_id', $productId);
        $this->statement->execute();
        
        return $this->statement->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function getUserFavourites($userId)
    {
        $sql = "SELECT p.* 
                FROM wishlist w
                JOIN product p ON w.product_id = p.id
                WHERE w.user_id = :user_id AND p.status IS NULL";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':user_id', $userId);
        $this->statement->execute();
        
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>