<?php

namespace Core;

final class Autoloader
{
    private static array $prefixes = [];

    public static function register(array $map)
    {
        self::$prefixes = $map + self::$prefixes;
        spl_autoload_register([self::class, 'load']);
    }
    private static function load(string $class)
    {
        foreach (self::$prefixes as $prefix => $baseDir) {
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                continue;
            }
            $relative = substr($class, $len);
            $file = $baseDir . '/' . str_replace('\\', '/', $relative) . '.php';
            if (is_file($file)) {
                require_once $file;
                return;
            }
        }
    }
}




