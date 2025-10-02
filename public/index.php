<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CORE_PATH', BASE_PATH . '/core');
define('CONFIG_PATH', BASE_PATH . '/config');

require_once CONFIG_PATH . '/env.php';
require_once CORE_PATH . '/Autoloader.php';

Core\Autoloader::register([
    'App\\' => APP_PATH,
    'Core\\' => CORE_PATH,
]);

Core\Session::start();
Core\Helpers::setupErrors((bool) ($_ENV['APP_DEBUG'] ?? false));

$router = new Core\Router();
$router->setBasePath(dirname($_SERVER['SCRIPT_NAME'] ?? '/'));

require BASE_PATH . '/routes/web.php';

try {
    $router->dispatch();
} catch (Throwable $e) {
    http_response_code(500);
    echo '<h2>Application Error</h2>';
    echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</p>';
    echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile(), ENT_QUOTES) . '</p>';
    echo '<p><strong>Line:</strong> ' . (int) $e->getLine() . '</p>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString(), ENT_QUOTES) . '</pre>';
}
