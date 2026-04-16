<?php

namespace App\Models;

use Core\Database;

class Session {

    public static function getActive(): array {
        $pdo  = Database::connect();
        $stmt = $pdo->query('
            SELECT s.*, g.name AS game_name, gc.copy_number AS game_copy_number, t.name AS table_name,
                   u.name AS client_name, r.duration_hours,
                   TIMESTAMPDIFF(MINUTE, s.started_at, NOW()) AS elapsed_minutes
            FROM sessions s
            JOIN games g        ON s.game_id = g.id
            LEFT JOIN game_copies gc ON s.game_copy_id = gc.id
            JOIN tables t       ON s.table_id = t.id
            JOIN reservations r ON s.reservation_id = r.id
            JOIN users u        ON r.user_id = u.id
            WHERE s.ended_at IS NULL
        ');
        return $stmt->fetchAll();
    }

    public static function getAllTablesWithStatus(): array {
        $pdo  = Database::connect();
        $stmt = $pdo->query('
            SELECT t.*,
                   s.id AS session_id, s.started_at,
                   g.name AS game_name,
                   u.name AS client_name,
                   r.duration_hours
            FROM tables t
            LEFT JOIN sessions s     ON s.table_id = t.id AND s.ended_at IS NULL
            LEFT JOIN games g        ON s.game_id = g.id
            LEFT JOIN reservations r ON s.reservation_id = r.id
            LEFT JOIN users u        ON r.user_id = u.id
        ');
        return $stmt->fetchAll();
    }

    public static function create(array $data): bool {
        $pdo  = Database::connect();
        $stmt = $pdo->prepare('
            INSERT INTO sessions (reservation_id, game_id, game_copy_id, table_id, started_at)
            VALUES (?, ?, ?, ?, NOW())
        ');
        return $stmt->execute([
            $data['reservation_id'],
            $data['game_id'],
            $data['game_copy_id'] ?? null,
            $data['table_id'],
        ]);
    }
    public static function find(int $id): array|false {
        $pdo  = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM sessions WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function end(int $id): bool {
        $pdo  = Database::connect();
        $stmt = $pdo->prepare('UPDATE sessions SET ended_at = NOW() WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function getAll(): array {
        $pdo  = Database::connect();
        $stmt = $pdo->query('
            SELECT s.*, g.name AS game_name, gc.copy_number AS game_copy_number, t.name AS table_name,
                u.name AS client_name,
                TIMESTAMPDIFF(MINUTE, s.started_at, s.ended_at) AS duration_minutes
            FROM sessions s
            JOIN games g        ON s.game_id = g.id
            LEFT JOIN game_copies gc ON s.game_copy_id = gc.id
            JOIN tables t       ON s.table_id = t.id
            JOIN reservations r ON s.reservation_id = r.id
            JOIN users u        ON r.user_id = u.id
            WHERE s.ended_at IS NOT NULL
            ORDER BY s.ended_at DESC
        ');
        return $stmt->fetchAll();
    }

    public static function getMostPlayedGames(): array {
        $pdo = Database::connect();

        $stmt = $pdo->prepare('
            SELECT g.name, COUNT(*) AS total_sessions
            FROM sessions s
            JOIN games g ON s.game_id = g.id
            GROUP BY s.game_id
            ORDER BY total_sessions DESC
            LIMIT 5
        ');

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPeakHours(): array {
        $pdo = Database::connect();

        $stmt = $pdo->prepare('
            SELECT HOUR(s.started_at) AS hour, COUNT(*) AS total_sessions
            FROM sessions s
            GROUP BY hour
            ORDER BY total_sessions DESC
        ');

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getTableUsage(): array {
        $pdo = Database::connect();

        $stmt = $pdo->prepare('
            SELECT 
                t.name,
                SUM(TIMESTAMPDIFF(MINUTE, s.started_at, s.ended_at)) AS total_minutes
            FROM sessions s
            JOIN tables t ON s.table_id = t.id
            WHERE s.ended_at IS NOT NULL
            GROUP BY s.table_id
            ORDER BY total_minutes DESC
        ');

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getCategoryStats(): array {
        $pdo = Database::connect();

        $stmt = $pdo->prepare('
            SELECT 
                g.category,
                COUNT(*) AS total_sessions
            FROM sessions s
            JOIN games g ON s.game_id = g.id
            GROUP BY g.category
            ORDER BY total_sessions DESC
        ');

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getRecommendedGames(): array {
        $pdo = Database::connect();

        $stmt = $pdo->prepare('
            SELECT 
                g.id,
                g.name,
                g.category,
                COUNT(s.id) AS total_sessions
            FROM games g
            LEFT JOIN sessions s ON g.id = s.game_id
            GROUP BY g.id
            ORDER BY total_sessions DESC
            LIMIT 5
        ');

        $stmt->execute();
        return $stmt->fetchAll();
    }
}