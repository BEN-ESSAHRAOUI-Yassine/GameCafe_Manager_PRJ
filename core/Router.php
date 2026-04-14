<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $uri, string $action): void {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, string $action): void {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes[$method] ?? [] as $route => $action) {
            // Convertir {id} en regex (\d+)
            $pattern = preg_replace('/\{[a-z]+\}/', '(\d+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // retirer le full match
                [$controllerName, $methodName] = explode('@', $action);
                $class = "App\\Controllers\\$controllerName";
                $controller = new $class();
                $controller->$methodName(...$matches);
                return;
            }
        }

        http_response_code(404);
        echo '<h1>404 — Page introuvable</h1>';
    }
}