<?php

class Database {

    private static $connection = null;

    public static function connect()
    {
        if (!self::$connection) {
            $hostname = getenv('DB_HOST') ?: 'localhost';
            $port     = getenv('DB_PORT') ?: '3306';
            $username = getenv('DB_USER') ?: 'root';
            $password = getenv('DB_PASS') ?: '';
            $dbname   = getenv('DB_NAME') ?: 'taotao';

            $dsn = "mysql:host=$hostname;port=$port;dbname=$dbname;charset=utf8mb4";

            try {
                self::$connection = new PDO($dsn, $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }

    public function disconnect()
    {
        self::$connection = null;
    }
}

?>
