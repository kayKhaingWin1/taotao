<?php

class Database {
    private static $connection = null;

    public static function connect() {
        if (!self::$connection) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . getenv('DB_HOST') . 
                    ";port=" . getenv('DB_PORT') . 
                    ";dbname=" . getenv('DB_NAME'),
                    getenv('DB_USER'),
                    getenv('DB_PASS'),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false, 
                    ]
                );
            } catch (PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                throw new Exception("Database connection error");
            }
        }
        return self::$connection;
    }

    public static function disconnect() {
        self::$connection = null;
    }
}

try {
    $db = Database::connect();
    echo "Connected to FreeDB successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>