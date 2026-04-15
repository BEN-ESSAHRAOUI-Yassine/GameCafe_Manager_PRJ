<?php

namespace App\Models;

use Core\Database;

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

    public static function insert(array $data): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('
            INSERT INTO games (name, category, description, difficulty, min_players, max_players, duration_minutes)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        return $stmt->execute([
            $data['name'], $data['category'], $data['description'],
            $data['difficulty'], $data['min_players'], $data['max_players'], $data['duration_minutes']
        ]);
    }

    public static function update(int $id, array $data): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('
            UPDATE games SET name=?, category=?, description=?, difficulty=?,
            min_players=?, max_players=?, duration_minutes=? WHERE id=?
        ');
        return $stmt->execute([
            $data['name'], $data['category'], $data['description'],
            $data['difficulty'], $data['min_players'], $data['max_players'],
            $data['duration_minutes'], $id
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('DELETE FROM games WHERE id = ?');
        return $stmt->execute([$id]);
    }
}