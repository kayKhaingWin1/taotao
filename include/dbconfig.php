<?php
class Database {
    private static $connection = null;

    public static function connect() {
        if (!self::$connection) {
            $hostname = getenv('DB_HOST') ?: 'dpg-d2dd47ogjchc73dj77p0-a';
            $port     = getenv('DB_PORT') ?: '5432';
            $username = getenv('DB_USER') ?: 'taotao_pg_user';
            $password = getenv('DB_PASS') ?: '3h4LCa5wyZV0XNqLZNAgQDMqDyiUp2f6';
            $dbname   = getenv('DB_NAME') ?: 'taotao_pg';

            // PostgreSQL DSN
            $dsn = "pgsql:host=$hostname;port=$port;dbname=$dbname";

            try {
                self::$connection = new PDO($dsn, $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }

    public function disconnect() {
        self::$connection = null;
    }
}
?>
