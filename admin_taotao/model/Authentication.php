<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Authentication {
    private $conn, $statement;

    // public function createAdmin($name, $email, $password): bool
    // {
    //     $this->conn = Database::connect();
    //     $sql = "insert into admin(name, email, password) values(:name, :email, :password)";
    //     $this->statement = $this->conn->prepare(query: $sql);
    //     $this->statement->bindParam(param: ':name', var: $name);
    //     $this->statement->bindParam(param: ':email', var: $email);
    //     $this->statement->bindParam(param: ':password', var: $password);
    //     return $this->statement->execute();
    // }

    public function createAdmin($name, $email, $password)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        return $stmt->rowCount() > 0;
    }
    // public function emailExists($email) {
    //     $query = "SELECT * FROM admins WHERE email = ?";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute([$email]);
    //     return $stmt->rowCount() > 0;
    // }

    public function emailExists($email) {
        $this->conn = Database::connect(); // Add this! Otherwise $this->conn is NULL
        $query = "SELECT * FROM admin WHERE email = ?"; // <-- change 'admins' to 'admin'
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }
    
    

    public function getAdmins()
    {
        $this->conn = Database::connect();
        $sql = "select * from admin";
        $this->statement = $this->conn->prepare($sql);
        if($this->statement->execute())
        {
            $results =  $this->statement->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
    }

    public function getAdmin($id)
    {
        $this->conn = Database::connect();
        $sql = "select * from admin where id=:id";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':id', $id);
        if($this->statement->execute())
        {
            $results =  $this->statement->fetch(PDO::FETCH_ASSOC);
            return $results;
        }
    }

    public function editPassword($password, $id){
        $this->conn = Database::connect();
        $sql = 'update admin set password = :password where id = :id';
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':password', $password);
        $this->statement->bindParam(':id', $id);
        return $this->statement->execute();
    }

    public function updatePassword($password, $email){
        $this->conn = Database::connect();
        $sql = 'update admin set password = :password where email = :email';
        $this->statement = $this->conn->prepare($sql);
        $this->statement->bindParam(':password', $password);
        $this->statement->bindParam(':email', $email);
        return $this->statement->execute();
    }
}

?>