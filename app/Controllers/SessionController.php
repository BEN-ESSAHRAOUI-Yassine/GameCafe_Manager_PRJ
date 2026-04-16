<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;
use App\Models\Session;
use App\Models\Game;

class SessionController extends Controller {

    // GET /sessions/dashboard
    public function dashboard(): void {
        $this->requireAdmin();
        $tables = Session::getAllTablesWithStatus();
        $this->view('sessions/dashboard', ['tables' => $tables]);
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

        $this->view('sessions/create', [
            'reservations' => $reservations,
            'games'        => $games,
        ]);
    }

    // POST /sessions
    public function store(): void {
        $this->requireAdmin();
        
        $reservationId = (int) $this->post('reservation_id');
        $gameId = (int) $this->post('game_id');
        
        // Get table_id from reservation
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT table_id FROM reservations WHERE id = ?");
        $stmt->execute([$reservationId]);
        $reservation = $stmt->fetch();
        $tableId = (int) $reservation['table_id'];
        
        Session::create([
            'reservation_id' => $reservationId,
            'game_id'       => $gameId,
            'table_id'     => $tableId,
        ]);

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
        $pdo->prepare("UPDATE games SET status = 'available' WHERE id = ?")
            ->execute([$session['game_id']]);
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