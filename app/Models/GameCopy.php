<?php

namespace App\Models;

use Core\Database;

class GameCopy {
    public static function getByGameId(int $gameId): array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM game_copies WHERE game_id = ? ORDER BY copy_number ASC');
        $stmt->execute([$gameId]);
        return $stmt->fetchAll();
    }

    public static function getCounts(int $gameId): array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = "available" THEN 1 ELSE 0 END) as available
            FROM game_copies WHERE game_id = ?
        ');
        $stmt->execute([$gameId]);
        $result = $stmt->fetch();
        return [
            'total' => (int) $result['total'],
            'available' => (int) $result['available']
        ];
    }

    public static function getNextCopyNumber(int $gameId): int {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT MAX(copy_number) as max_copy FROM game_copies WHERE game_id = ?');
        $stmt->execute([$gameId]);
        $result = $stmt->fetch();
        return ((int) $result['max_copy']) + 1;
    }

    public static function create(int $gameId, int $copyNumber): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('INSERT INTO game_copies (game_id, copy_number, status) VALUES (?, ?, ?)');
        return $stmt->execute([$gameId, $copyNumber, 'available']);
    }

    public static function getAllWithCounts(): array {
        $pdo = Database::connect();
        $stmt = $pdo->query('
            SELECT 
                g.id,
                g.name,
                COUNT(c.id) as total,
                SUM(CASE WHEN c.status = "available" THEN 1 ELSE 0 END) as available
            FROM games g
            LEFT JOIN game_copies c ON g.id = c.game_id
            GROUP BY g.id, g.name
            ORDER BY g.name ASC
        ');
        return $stmt->fetchAll();
    }

    public static function updateStatus(int $id, string $status): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('UPDATE game_copies SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }
}