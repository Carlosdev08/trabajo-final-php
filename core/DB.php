<?php
namespace Core;


use PDO;
use PDOException;


final class DB
{
    private static ?PDO $pdo = null;


    public static function pdo(): PDO
    {
        if (self::$pdo)
            return self::$pdo;


        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $_ENV['DB_HOST'] ?? '127.0.0.1',
            (int) ($_ENV['DB_PORT'] ?? 3306),
            $_ENV['DB_NAME'] ?? 'newsletters'
        );
        try {
            self::$pdo = new PDO($dsn, $_ENV['DB_USER'] ?? 'root', $_ENV['DB_PASS'] ?? '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            exit('Error de conexión BD: ' . htmlspecialchars($e->getMessage()));
        }
        return self::$pdo;
    }
}