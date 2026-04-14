<?php

namespace App\Models;

use App\Core\Database;

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
            VALUES (?, ?, ?, ?, "client")
        ');
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            password_hash($data['password'], PASSWORD_BCRYPT),
        ]);
    }

    public static function find(int $id): array|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}