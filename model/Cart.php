<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Cart
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }


    public function addToCart($user_id, $product_size_color_id, $quantity)
    {

        $sql = "SELECT * FROM cart WHERE user_id = :user_id AND product_size_color_id = :psc_id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':user_id', $user_id);
        $this->statement->bindParam(':psc_id', $product_size_color_id);
        $this->statement->execute();
        $existingItem = $this->statement->fetch(PDO::FETCH_ASSOC);

        if ($existingItem) {

            $newQuantity = $existingItem['quantity'] + $quantity;
            $sql = "UPDATE cart SET quantity = :quantity WHERE id = :id";
            $this->statement = $this->conn->prepare($sql);
            $this->statement->bindParam(':quantity', $newQuantity);
            $this->statement->bindParam(':id', $existingItem['id']);
            return $this->statement->execute();
        } else {
            $sql = "INSERT INTO cart (user_id, product_size_color_id, quantity) VALUES (:user_id, :psc_id, :quantity)";
            $this->statement = $this->conn->prepare($sql);
            $this->statement->bindParam(':user_id', $user_id);
            $this->statement->bindParam(':psc_id', $product_size_color_id);
            $this->statement->bindParam(':quantity', $quantity);
            return $this->statement->execute();
        }
    }

    public function getCartItems($user_id)
    {
        $sql = "SELECT 
                c.id AS cart_id,
                c.quantity,
                p.id AS product_id,
                p.name AS product_name,
                p.image,
                p.price AS price,          
                s.size AS size,
                co.color AS color,
                co.color_code
            FROM cart c
            JOIN product_size_color psc ON c.product_size_color_id = psc.id
            JOIN product p ON psc.product_id = p.id
            JOIN size s ON psc.size_id = s.id
            JOIN color co ON psc.color_id = co.id
            WHERE c.user_id = :user_id";

        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':user_id', $user_id);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }



    public function removeFromCart($cart_id)
    {
        $sql = "DELETE FROM cart WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $cart_id);
        return $this->statement->execute();
    }

    public function clearCart($user_id)
    {
        $sql = "DELETE FROM cart WHERE user_id = :user_id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':user_id', $user_id);
        return $this->statement->execute();
    }

    public function getUniqueCartItemCount($user_id)
    {
        $sql = "SELECT 
                COUNT(DISTINCT CONCAT(p.name, '-', s.size, '-', co.color)) AS unique_count
            FROM cart c
            JOIN product_size_color psc ON c.product_size_color_id = psc.id
            JOIN product p ON psc.product_id = p.id
            JOIN size s ON psc.size_id = s.id
            JOIN color co ON psc.color_id = co.id
            WHERE c.user_id = :user_id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':user_id', $user_id);
        $this->statement->execute();
        $result = $this->statement->fetch(PDO::FETCH_ASSOC);
        return $result['unique_count'] ?? 0;
    }
    public function updateCartQuantity($cart_id, $quantity)
    {
        $sql = "UPDATE cart SET quantity = :quantity WHERE id = :cart_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
