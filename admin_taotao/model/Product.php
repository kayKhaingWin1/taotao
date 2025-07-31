<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Product {
    private $conn, $statement;

    public function getProducts()
    {
        $this->conn = Database::connect();
        $sql = "SELECT product.*, brand.name AS brand_name, subcategory.name AS sub_name
                FROM product
                JOIN brand ON product.brand_id = brand.id
                JOIN subcategory ON product.sub_id = subcategory.id
                WHERE product.status IS NULL OR product.status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        if ($this->statement->execute()) {
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function addProduct($name, $price, $description, $image, $brand_id, $sub_id)
    {
        $this->conn = Database::connect();
        $sql = "INSERT INTO product (name, price, description, image, brand_id, sub_id)
                VALUES (:name, :price, :description, :image, :brand_id, :sub_id)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':price', $price);
        $this->statement->bindParam(':description', $description);
        $this->statement->bindParam(':image', $image);
        $this->statement->bindParam(':brand_id', $brand_id);
        $this->statement->bindParam(':sub_id', $sub_id);
        return $this->statement->execute();
    }

    public function getProduct($id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM product WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        if ($this->statement->execute()) {
            return $this->statement->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function editProduct($id, $name, $price, $description, $image, $brand_id, $sub_id)
    {
        $this->conn = Database::connect();
        $sql = "UPDATE product SET name = :name, price = :price, description = :description, 
                image = :image, brand_id = :brand_id, sub_id = :sub_id WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':price', $price);
        $this->statement->bindParam(':description', $description);
        $this->statement->bindParam(':image', $image);
        $this->statement->bindParam(':brand_id', $brand_id);
        $this->statement->bindParam(':sub_id', $sub_id);
        return $this->statement->execute();
    }

    public function deleteProduct($id)
    {
        $this->conn = Database::connect();
        $sql = "UPDATE product SET status = 'deleted' WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        return $this->statement->execute();
    }

    public function getColorSizesByProduct($product_id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT pcs.color_id, pcs.size_id, c.color, c.color_code, s.size
                FROM product_size_color pcs
                JOIN color c ON pcs.color_id = c.id
                JOIN size s ON pcs.size_id = s.id
                WHERE pcs.product_id = :product_id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':product_id', $product_id);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProductColorSize($product_id, $color_id, $size_id)
    {
        $this->conn = Database::connect();
        $sql = "INSERT INTO product_size_color (product_id, color_id, size_id)
                VALUES (:product_id, :color_id, :size_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':color_id', $color_id);
        $stmt->bindParam(':size_id', $size_id);
        return $stmt->execute();
    }

    public function deleteProductColorSize($product_id)
    {
        $this->conn = Database::connect();
        $sql = "DELETE FROM product_size_color WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }

    public function getDiscountByProductId($product_id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT d.id, d.discount, d.voucher_code
                FROM discount_product dp
                JOIN discount d ON dp.discount_id = d.id
                WHERE dp.product_id = :product_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addDiscountToProduct($product_id, $discount_id)
    {
        $this->conn = Database::connect();
        $sql = "INSERT INTO discount_product (discount_id, product_id)
                VALUES (:discount_id, :product_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':discount_id', $discount_id);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }

    public function deleteDiscountFromProduct($product_id)
    {
        $this->conn = Database::connect();
        $sql = "DELETE FROM discount_product WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }

    public function getLastInsertedId()
    {
        return $this->conn->lastInsertId();
    }
}
