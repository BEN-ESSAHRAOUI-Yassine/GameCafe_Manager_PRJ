<?php

namespace Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        
        $viewFile = dirname(__DIR__) . '/app/Views/' . $view . '.php';
        
        if (!file_exists($viewFile)) {
            $this->notFound();
            return;
        }
        
        require dirname(__DIR__) . '/app/Views/layouts/header.php';
        require $viewFile;
        require dirname(__DIR__) . '/app/Views/layouts/footer.php';
    }
    
    protected function redirect(string $url): void
    {
        $url = '/' . ltrim($url, '/');
        header('Location: ' .  BASE_URL . $url);
        exit;
    }
    
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    public function notFound(): void
    {
        http_response_code(404);
        echo '<!DOCTYPE html>
        <html>
        <head><title>404 - Page Not Found</title></head>
        <body>
            <h1>404 - Page Not Found</h1>
            <p>The page you are looking for does not exist.</p>
            <a href="' . BASE_URL . '/home">Go to Home</a>
        </body>
        </html>';
        exit;
    }
    
    protected function unauthorized(): void
    {
        http_response_code(403);
        echo '<!DOCTYPE html>
        <html>
        <head><title>403 - Unauthorized</title></head>
        <body>
            <h1>403 - Unauthorized</h1>
            <p>You do not have permission to access this page.</p>
            <a href="' . BASE_URL . '/home">Go to Home</a>
        </body>
        </html>';
        exit;
    }
    
    public static function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin(): bool {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    protected function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }
    
    protected function requireAdmin(): void
    {
        if (!$this->isAdmin()) {
            $this->unauthorized();
        }
    }
    
    protected function getUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }
    
    protected function getUserRole(): ?string
    {
        return $_SESSION['role'] ?? null;
    }
    
    protected function old(string $key): string
    {
        return $_SESSION['old'][$key] ?? '';
    }
    
    protected function clearOld(): void
    {
        unset($_SESSION['old']);
    }
    
    protected function with(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    
    protected function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }
    
    protected function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }
}
