<?php

namespace Core;

define('BASE_URL', '/GameCafe_Manager_PRJ/public');
class Router {
    private array $routes = [];

    public function get(string $uri, string $action, array $middlewares = []): void {
        $this->routes['GET'][$uri] = [
            'action' => $action,
            'middlewares' => $middlewares
        ];
    }

    public function post(string $uri, string $action, array $middlewares = []): void {
        $this->routes['POST'][$uri] = [
            'action' => $action,
            'middlewares' => $middlewares
        ];
    }

public function dispatch(): void {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: '/';
    $basePath = '/GameCafe_Manager_PRJ/public';
    $uri = str_replace($basePath, '', $uri) ?? '/';
    if (!isset($this->routes[$method])) {
        http_response_code(405);
        echo "Method Not Allowed";
        return;
    }
    foreach ($this->routes[$method] as $route => $data) {
        $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([^/]+)', $route);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches);

            $action = $data['action'];
            $middlewares = $data['middlewares'];

            //  RUN MIDDLEWARE FIRST
            foreach ($middlewares as $middleware) {
                $class = "Core\\Middleware\\$middleware";

                if (!class_exists($class)) {
                    http_response_code(500);
                    echo "Middleware $middleware not found";
                    return;
                }

                (new $class())->handle();
            }

            //  THEN CONTROLLER
            [$controllerName, $methodName] = explode('@', $action);
            $class = "App\\Controllers\\$controllerName";

            if (!class_exists($class)) {
                http_response_code(404);
                echo "Controller not found";
                return;
            }

            $controller = new $class();

            if (!method_exists($controller, $methodName)) {
                http_response_code(404);
                echo "Method not found";
                return;
            }

            $controller->$methodName(...$matches);
            return;
        }
    }

    (new \Core\Controller())->notFound();
}
}