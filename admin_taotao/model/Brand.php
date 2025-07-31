<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Brand {
    private $conn, $statement;

    public function getBrands()
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM brand";
        $this->statement = $this->conn->prepare($sql);
        if ($this->statement->execute()) {
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function addBrand($name, $profile, $profile_img, $bg_img, $address)
    {
        $this->conn = Database::connect();
        $sql = "INSERT INTO brand (name, profile, profile_img, bg_img, address)
                VALUES (:name, :profile, :profile_img, :bg_img, :address)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':profile', $profile);
        $this->statement->bindParam(':profile_img', $profile_img);
        $this->statement->bindParam(':bg_img', $bg_img);
        $this->statement->bindParam(':address', $address);
        return $this->statement->execute();
    }

    public function getBrand($id)
    {
        $this->conn = Database::connect();
        $sql = "SELECT * FROM brand WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        if ($this->statement->execute()) {
            return $this->statement->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function editBrand($id, $name, $profile, $profile_img, $bg_img, $address)
    {
        $this->conn = Database::connect();
        $sql = "UPDATE brand SET name = :name, profile = :profile, profile_img = :profile_img, bg_img = :bg_img, address = :address WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':profile', $profile);
        $this->statement->bindParam(':profile_img', $profile_img);
        $this->statement->bindParam(':bg_img', $bg_img);
        $this->statement->bindParam(':address', $address);
        return $this->statement->execute();
    }

    public function deleteBrand($id)
    {
        $this->conn = Database::connect();
        $sql = "DELETE FROM brand WHERE id = :id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        return $this->statement->execute();
    }
}
