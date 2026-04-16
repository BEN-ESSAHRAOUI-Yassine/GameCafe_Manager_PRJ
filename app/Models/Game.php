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

    public static function allWithAvailability(): array {
        $pdo = Database::connect();
        $stmt = $pdo->query('
            SELECT 
                g.*,
                COALESCE(COUNT(c.id), 0) as total_copies,
                COALESCE(SUM(CASE WHEN c.status = "available" THEN 1 ELSE 0 END), 0) as available_copies
            FROM games g
            LEFT JOIN game_copies c ON g.id = c.game_id
            GROUP BY g.id
            ORDER BY g.name ASC
        ');
        return $stmt->fetchAll();
    }

    public static function findWithAvailability(int $id): array|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('
            SELECT 
                g.*,
                COALESCE(COUNT(c.id), 0) as total_copies,
                COALESCE(SUM(CASE WHEN c.status = "available" THEN 1 ELSE 0 END), 0) as available_copies
            FROM games g
            LEFT JOIN game_copies c ON g.id = c.game_id
            WHERE g.id = ?
            GROUP BY g.id
        ');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}