<?php
namespace Core;

final class CSRF
{
    private static $tokenName = '_csrf_token';

    public static function generateToken(): string
    {
        if (!isset($_SESSION[self::$tokenName])) {
            $_SESSION[self::$tokenName] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::$tokenName];
    }

    public static function getTokenInput(): string
    {
        $token = self::generateToken();
        return '<input type="hidden" name="' . self::$tokenName . '" value="' . htmlspecialchars($token) . '">';
    }

    public static function validateToken(?string $token = null): bool
    {
        if ($token === null) {
            $token = $_POST[self::$tokenName] ?? '';
        }

        if (!isset($_SESSION[self::$tokenName]) || empty($token)) {
            return false;
        }

        return hash_equals($_SESSION[self::$tokenName], $token);
    }

    public static function regenerateToken(): string
    {
        unset($_SESSION[self::$tokenName]);
        return self::generateToken();
    }
}