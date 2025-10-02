<?php
namespace Core;

final class SecurityLogger
{
    private static $logFile = 'logs/security.log';

    public static function log(string $level, string $message, array $context = []): void
    {
        $logDir = dirname(self::$logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        $user = $_SESSION['user_id'] ?? 'anonymous';

        $logData = [
            'timestamp' => $timestamp,
            'level' => strtoupper($level),
            'message' => $message,
            'ip' => $ip,
            'user_id' => $user,
            'user_agent' => $userAgent,
            'context' => $context
        ];

        $logLine = json_encode($logData) . PHP_EOL;

        error_log($logLine, 3, self::$logFile);
    }

    public static function logInfo(string $message, array $context = []): void
    {
        self::log('INFO', $message, $context);
    }

    public static function logWarning(string $message, array $context = []): void
    {
        self::log('WARNING', $message, $context);
    }

    public static function logError(string $message, array $context = []): void
    {
        self::log('ERROR', $message, $context);
    }

    public static function logSecurity(string $message, array $context = []): void
    {
        self::log('SECURITY', $message, $context);
    }

    // Eventos específicos de seguridad
    public static function logLoginAttempt(string $username, bool $success): void
    {
        $message = $success ? "Login exitoso para usuario: $username" : "Intento de login fallido para usuario: $username";
        $level = $success ? 'INFO' : 'WARNING';
        self::log($level, $message, ['username' => $username, 'success' => $success]);
    }

    public static function logPasswordChange(string $username): void
    {
        self::logSecurity("Cambio de contraseña para usuario: $username", ['username' => $username]);
    }

    public static function logUserCreation(string $username, string $role): void
    {
        self::logInfo("Usuario creado: $username con rol: $role", ['username' => $username, 'role' => $role]);
    }

    public static function logCSRFFailure(): void
    {
        self::logSecurity("Token CSRF inválido detectado", []);
    }

    public static function logRateLimitExceeded(string $action): void
    {
        self::logWarning("Rate limit excedido para acción: $action", ['action' => $action]);
    }
}