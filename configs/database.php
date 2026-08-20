<?php

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $host   = defined('DB_HOST') ? DB_HOST : 'localhost';
            $port   = defined('DB_PORT') ? DB_PORT : '3306';
            $dbname = defined('DB_NAME') ? DB_NAME : 'shop_quanao';
            $user   = defined('DB_USERNAME') ? DB_USERNAME : 'root';
            $pass   = defined('DB_PASSWORD') ? DB_PASSWORD : '123456';

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Fallback attempt with empty password if configured password fails
                try {
                    self::$pdo = new PDO($dsn, $user, '', $options);
                } catch (PDOException $e2) {
                    throw $e;
                }
            }
        }

        return self::$pdo;
    }
}