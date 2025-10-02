<?php
namespace Core;


final class Helpers
{
    public static function setupErrors(bool $debug): void
    {
        if ($debug) {
            ini_set('display_errors', '1');
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', '0');
            error_reporting(0);
        }
    }


    public static function e(?string $v): string
    {
        return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
    }


    public static function baseUrl(string $path = ''): string
    {
        $base = rtrim($_ENV['APP_URL'] ?? '/', '/');
        return $base . '/' . ltrim($path, '/');
    }


    public static function asset(string $path): string
    {
        return self::baseUrl('assets/' . ltrim($path, '/'));
    }
}