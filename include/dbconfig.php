<?php

class Database {

    private static $connection = null;

    public static function connect()
    {
        if (!self::$connection) {
            $hostname = getenv('DB_HOST');
            $port     = getenv('DB_PORT');
            $username = getenv('DB_USER');
            $password = getenv('DB_PASS');
            $dbname   = getenv('DB_NAME');

            $dsn = "mysql:host=$hostname;port=$port;dbname=$dbname";

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
