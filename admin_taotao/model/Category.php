<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Category {
    private $conn, $statement;

    public function getCategories()
{
    $this->conn = Database::connect();
    $sql = "SELECT * FROM category WHERE status IS NULL OR status != 'deleted'";
    $this->statement = $this->conn->prepare($sql);
    if ($this->statement->execute()) {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}


    public function addCategory($name, $image)
    {
        $this->conn = Database::connect();
        $sql = "insert into category (name,image) values (:name, :image)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':image', $image);
        return $this->statement->execute();
    }

    public function getCategory($id)
    {
        $this->conn = Database::connect();
        $sql = "select * from category where id=:id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        if ($this->statement->execute()) {
            $results = $this->statement->fetch(PDO::FETCH_ASSOC);
            return $results;
        }
    }

    public function editCategory($id, $name, $image)
    {
        $this->conn = Database::connect();
        $sql = "update category set name=:name,image=:image where id=:id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':image', $image);
        return $this->statement->execute();
    }

    public function deleteCategory($id)
    {
        $status = 'deleted';
        $this->conn = Database::connect();
        $sql = "update category set status=:status where id=:id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        $this->statement->bindParam(':status', $status);
        return $this->statement->execute();
    }

    // public function getMenuByRestaurant($restaurant_id)
    // {
    //     $this->conn = Database::connect();
    //     $sql = "SELECT m.id, m.name
    //             FROM menu AS m
    //             JOIN restaurant_menu AS rm ON m.id = rm.menu_id
    //             WHERE rm.restaurant_id = :restaurant_id";
    //     $this->statement = $this->conn->prepare($sql);
    //     $this->statement->bindParam(':restaurant_id', $restaurant_id);
    //     if($this->statement->execute())
    //     {
    //         $results = $this->statement->fetchAll(PDO::FETCH_ASSOC);
    //         return $results;
    //     }
    // }

    // public function getTotalMenus()
    // {
    //     $this->conn = Database::connect();
    //     $sql = "SELECT COUNT(*) as total_menus FROM menu";
    //     $this->statement = $this->conn->prepare($sql);
    //     if ($this->statement->execute()) {
    //         $result = $this->statement->fetch(PDO::FETCH_ASSOC);
    //         return $result['total_menus'];
    //     }
    // }

}
