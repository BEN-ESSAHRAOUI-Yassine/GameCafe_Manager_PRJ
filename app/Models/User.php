<?php

namespace App\Models;

use Core\Database;

class User {

    public static function findByEmail(string $email): array|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function create(array $data): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('
            INSERT INTO users (name, email, phone, password, role)
            VALUES (?, ?, ?, ?, ?)
        ');
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['role'],
        ]);
    }

    public static function find(int $id): array|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function adminExists() {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role='admin'");
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}