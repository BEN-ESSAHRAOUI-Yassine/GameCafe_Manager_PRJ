<?php
namespace Core\Middleware;

use Core\Controller;

class AuthMiddleware {
    public function handle() {
        if (!Controller::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }
}