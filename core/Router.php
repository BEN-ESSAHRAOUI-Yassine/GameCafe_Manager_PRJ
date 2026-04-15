<?php

namespace Core;

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
    if (str_starts_with($uri, BASE_URL)) {
        $uri = substr($uri, strlen(BASE_URL));
    }
    //echo "A<br>";
    $uri = '/' . ltrim($uri, '/');

    // fallback
    if ($uri === '') {
        $uri = '/';
    }
    //var_dump($uri);
    //var_dump($method);
    //var_dump($this->routes[$method] ?? 'NO ROUTES FOR THIS METHOD');
    //exit;
    if (!isset($this->routes[$method])) {
        http_response_code(405);
        echo "Method Not Allowed";
        return;
    }
    foreach ($this->routes[$method] as $route => $data) {
        $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([^/]+)', $route);
        $pattern = '#^' . $pattern . '$#';
        //var_dump($route, $pattern, $uri);
        
        //if (preg_match($pattern, $uri, $matches)) {
        //   var_dump("MATCHED!", $route);
        //   exit;
        //}
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