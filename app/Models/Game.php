<?php

namespace App\Models;

use App\Core\Database;

class Game {
    public static function all(): array {
        $pdo = Database::connect();
        $stmt = $pdo->query('SELECT * FROM games ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): array|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM games WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function allByCategory(string $category): array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM games WHERE category = ? ORDER BY name ASC');
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }
}