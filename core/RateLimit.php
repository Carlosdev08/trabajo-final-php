<?php
namespace Core;

final class RateLimit
{
    private static $sessionKey = '_rate_limits';

    public static function check(string $action, int $maxAttempts = 5, int $timeWindow = 300): bool
    {
        if (!isset($_SESSION[self::$sessionKey])) {
            $_SESSION[self::$sessionKey] = [];
        }

        $now = time();
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = $action . '_' . $ip;

        // Limpiar intentos antiguos
        if (isset($_SESSION[self::$sessionKey][$key])) {
            $_SESSION[self::$sessionKey][$key] = array_filter(
                $_SESSION[self::$sessionKey][$key],
                fn($timestamp) => ($now - $timestamp) < $timeWindow
            );
        } else {
            $_SESSION[self::$sessionKey][$key] = [];
        }

        // Verificar si se excedió el límite
        if (count($_SESSION[self::$sessionKey][$key]) >= $maxAttempts) {
            SecurityLogger::logRateLimitExceeded($action);
            return false;
        }

        return true;
    }

    public static function record(string $action): void
    {
        if (!isset($_SESSION[self::$sessionKey])) {
            $_SESSION[self::$sessionKey] = [];
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = $action . '_' . $ip;

        if (!isset($_SESSION[self::$sessionKey][$key])) {
            $_SESSION[self::$sessionKey][$key] = [];
        }

        $_SESSION[self::$sessionKey][$key][] = time();
    }

    public static function reset(string $action): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = $action . '_' . $ip;

        if (isset($_SESSION[self::$sessionKey][$key])) {
            unset($_SESSION[self::$sessionKey][$key]);
        }
    }

    public static function getRemainingTime(string $action, int $timeWindow = 300): int
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = $action . '_' . $ip;

        if (!isset($_SESSION[self::$sessionKey][$key]) || empty($_SESSION[self::$sessionKey][$key])) {
            return 0;
        }

        $oldestAttempt = min($_SESSION[self::$sessionKey][$key]);
        $elapsed = time() - $oldestAttempt;

        return max(0, $timeWindow - $elapsed);
    }
}