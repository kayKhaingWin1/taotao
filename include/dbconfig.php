<?php

class Database {
    private static $connection = null;

    public static function connect() {
        if (!self::$connection) {
            $hostname = getenv('DB_HOST');
            $port     = getenv('DB_PORT');
            $dbname   = getenv('DB_NAME');
            $username = getenv('DB_USER');
            $password = getenv('DB_PASS');

            $dsn = "mysql:host=$hostname;port=$port;dbname=$dbname;charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 30, 
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
                PDO::MYSQL_ATTR_SSL_CA => true, 
            ];

            try {
                self::$connection = new PDO($dsn, $username, $password, $options);
                error_log("✅ 数据库连接成功建立");
            } catch (PDOException $e) {
                error_log("❌ 数据库连接失败: " . $e->getMessage());
                error_log("连接参数: host=$hostname, db=$dbname, user=$username");

                throw new Exception("数据库连接暂时不可用，请稍后重试");
            }
        }

        return self::$connection;
    }

    public static function disconnect() {
        self::$connection = null;
    }

    public static function checkConnection() {
        try {
            $conn = self::connect();
            $conn->query("SELECT 1");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

try {
    $db = Database::connect();

} catch (Exception $e) {
    if (getenv('APP_ENV') === 'production') {
        include 'views/maintenance.html';
        exit;
    } else {
        die("Database Error: " . $e->getMessage());
    }
}