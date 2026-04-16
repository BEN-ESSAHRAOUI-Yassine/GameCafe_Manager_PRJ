<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;
use App\Models\Session;
use App\Models\Game;
use App\Models\GameCopy;

class SessionController extends Controller {

    // GET /sessions/dashboard
    public function dashboard(): void {
        $this->requireAdmin();

        $tables = Session::getAllTablesWithStatus();

        // 📊 Stats
        $mostPlayed   = Session::getMostPlayedGames();
        $peakHours    = Session::getPeakHours();
        $tableUsage   = Session::getTableUsage();
        $categories   = Session::getCategoryStats();

        $this->view('sessions/dashboard', [
            'tables'      => $tables,
            'mostPlayed'  => $mostPlayed,
            'peakHours'   => $peakHours,
            'tableUsage'  => $tableUsage,
            'categories'  => $categories,
        ]);
    }

    // GET /sessions/create
    public function create(): void {
        $this->requireAdmin();

        $pdo  = Database::connect();
        $stmt = $pdo->query('
            SELECT r.*, u.name AS client_name, t.name AS table_name
            FROM reservations r
            JOIN users u  ON r.user_id = u.id
            JOIN tables t ON r.table_id = t.id
            WHERE r.status = "confirmed"
            AND r.id NOT IN (SELECT reservation_id FROM sessions WHERE ended_at IS NULL)
        ');
        $reservations = $stmt->fetchAll();
        $games = Game::allWithAvailability();
        $gameCopies = GameCopy::getAvailableWithGame();

        $this->view('sessions/create', [
            'reservations' => $reservations,
            'games'        => $games,
            'gameCopies'   => $gameCopies,
        ]);
    }

// POST /sessions
    public function store(): void {
        $this->requireAdmin();
        
        $reservationId = (int) $this->post('reservation_id');
        $gameId = (int) $this->post('game_id');
        $gameCopyId = (int) $this->post('game_copy_id') ?: null;
        
        // Get table_id from reservation
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT table_id FROM reservations WHERE id = ?");
        $stmt->execute([$reservationId]);
        $reservation = $stmt->fetch();
        $tableId = (int) $reservation['table_id'];
        
        Session::create([
            'reservation_id' => $reservationId,
            'game_id'       => $gameId,
            'game_copy_id'  => $gameCopyId,
            'table_id'      => $tableId,
        ]);

        if ($gameCopyId) {
            GameCopy::updateStatus($gameCopyId, 'in_use');
        }
        
        $pdo->prepare("UPDATE tables SET status = 'occupied' WHERE id = ?")
            ->execute([$tableId]);
        
        $this->redirect('/sessions/dashboard');
    }

    // POST /sessions/{id}/end
    public function end(int $id): void {
        $this->requireAdmin();

        $session = Session::find($id);
        if (!$session) $this->notFound();

        Session::end($id);

        $pdo = Database::connect();
        $pdo->prepare("UPDATE tables SET status = 'available' WHERE id = ?")
            ->execute([$session['table_id']]);
        
        if ($session['game_copy_id']) {
            GameCopy::updateStatus($session['game_copy_id'], 'available');
        }
        
        $pdo->prepare("UPDATE reservations SET status = 'completed' WHERE id = ?")
            ->execute([$session['reservation_id']]);

        $this->redirect('/sessions/dashboard');
    }

    // GET /sessions/history
    public function history(): void {
        $this->requireAdmin();
        $sessions = Session::getAll();
        $this->view('sessions/history', ['sessions' => $sessions]);
    }
}