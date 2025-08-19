<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Authentication {
    private $conn, $statement;

    public function createUser($name, $email, $password)
    {
        $this->conn = Database::connect();
        $sql = "insert into user(name, email, password) values(:name, :email, :password)";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':name', $name);
        $this->statement->bindParam(':email', $email);
        $this->statement->bindParam(':password', $password);
        return $this->statement->execute();
    }

    public function getUsers()
    {
        $this->conn = Database::connect();
        $sql = "select * from user";
        $this->statement = $this->conn->prepare($sql);
        if($this->statement->execute())
        {
            $results =  $this->statement->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
    }

    public function getUser($id)
    {
        $this->conn = Database::connect();
        $sql = "select * from user where id=:id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        if($this->statement->execute())
        {
            $results =  $this->statement->fetch(PDO::FETCH_ASSOC);
            return $results;
        }
    }
    //   public function updateUser($id, $name = null, $email = null, $password = null, 
    //                          $address = null, $phone_no = null, $profile_img = null)
    // {
    //     $this->conn = Database::connect();
    //     $sql = "UPDATE user SET ";
    //     $updates = [];
    //     $params = [':id' => $id];

    //     if ($name !== null) {
    //         $updates[] = "name = :name";
    //         $params[':name'] = $name;
    //     }
    //     if ($email !== null) {
    //         $updates[] = "email = :email";
    //         $params[':email'] = $email;
    //     }
    //     if ($password !== null) {
    //         $updates[] = "password = :password";
    //         $params[':password'] = $password;
    //     }
    //     if ($address !== null) {
    //         $updates[] = "address = :address";
    //         $params[':address'] = $address;
    //     }
    //     if ($phone_no !== null) {
    //         $updates[] = "phone_no = :phone_no";
    //         $params[':phone_no'] = $phone_no;
    //     }
    //     if ($profile_img !== null) {
    //         $updates[] = "profile_img = :profile_img";
    //         $params[':profile_img'] = $profile_img;
    //     }

    //     if (empty($updates)) {
    //         return false;
    //     }

    //     $sql .= implode(', ', $updates) . " WHERE id = :id";
    //     $this->statement = $this->conn->prepare($sql);
    //     return $this->statement->execute($params);
    // }

    public function updateUser($id, $name = null, $email = null, $password = null, $address = null, $phone = null)
{
    $this->conn = Database::connect();
    $sql = "UPDATE user SET ";
    $updates = [];
    $params = [];

    if ($name !== null) {
        $updates[] = "name = :name";
        $params[':name'] = $name;
    }
    if ($email !== null) {
        $updates[] = "email = :email";
        $params[':email'] = $email;
    }
    if ($password !== null) {
        $updates[] = "password = :password";
        $params[':password'] = $password;
    }
    if ($address !== null) {
        $updates[] = "address = :address";
        $params[':address'] = $address;
    }
    if ($phone !== null) {
        $updates[] = "phone = :phone";
        $params[':phone'] = $phone;
    }

    if (empty($updates)) {
        return false;
    }

    $sql .= implode(', ', $updates) . " WHERE id = :id";
    $params[':id'] = $id;

    $this->statement = $this->conn->prepare($sql);
    return $this->statement->execute($params);
}
}

?>