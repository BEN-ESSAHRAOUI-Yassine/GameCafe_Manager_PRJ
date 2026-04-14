<?php
namespace Core\Middleware;

use Core\Controller;

class AdminMiddleware {
    public function handle() {
        if (!Controller::isAdmin()) {
            http_response_code(403);
            echo "Forbidden";
            exit;
        }
    }
}