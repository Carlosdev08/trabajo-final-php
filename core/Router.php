<?php
namespace Core;

final class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    private string $basePath = '';

    public function setBasePath(string $basePath): void
    {
        $basePath = '/' . trim($basePath, '/');
        $this->basePath = $basePath === '/' ? '' : $basePath;
    }

    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][$this->normalize($path)] = $handler;
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][$this->normalize($path)] = $handler;
    }

    public function dispatch(): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        if ($method === 'HEAD') {
            $method = 'GET';
        }

        if (!isset($this->routes[$method])) {
            http_response_code(405);
            echo '405 Method Not Allowed';
            return;
        }

        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $path = $this->normalize($this->stripBasePath($uri));

        $handler = $this->routes[$method][$path] ?? null;
        if ($handler === null) {
            http_response_code(404);
            echo '404 Not Found';
            return;
        }

        if (is_array($handler)) {
            [$class, $methodName] = $handler;
            $controller = new $class();
            $response = $controller->{$methodName}();
        } else {
            $response = call_user_func($handler);
        }

        if ($response !== null) {
            echo $response;
        }
    }

    private function normalize(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        return rtrim($path, '/') ?: '/';
    }

    private function stripBasePath(string $uri): string
    {
        if ($this->basePath === '') {
            return $uri;
        }

        $length = strlen($this->basePath);
        if (strncmp($uri, $this->basePath, $length) !== 0) {
            return $uri;
        }

        $stripped = substr($uri, $length);
        if ($stripped === false || $stripped === '') {
            return '/';
        }

        return $stripped;
    }
}
