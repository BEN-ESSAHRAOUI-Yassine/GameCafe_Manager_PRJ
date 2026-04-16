<?php

namespace App\Controllers;

use App\Models\Game;
use App\Models\GameCopy;
use Core\Controller;

class GameController extends Controller {

    public function index(): void {
        $category = $this->get('category');
        $validCategories = ['Stratégie', 'Ambiance', 'Famille', 'Experts'];

        if ($category && in_array($category, $validCategories)) {
            $pdo = \Core\Database::connect();
            $stmt = $pdo->prepare('
                SELECT 
                    g.*,
                    COALESCE(COUNT(c.id), 0) as total_copies,
                    COALESCE(SUM(CASE WHEN c.status = "available" THEN 1 ELSE 0 END), 0) as available_copies
                FROM games g
                LEFT JOIN game_copies c ON g.id = c.game_id
                WHERE g.category = ?
                GROUP BY g.id
                ORDER BY g.name ASC
            ');
            $stmt->execute([$category]);
            $games = $stmt->fetchAll();
        } else {
            $games = Game::allWithAvailability();
            $category = null;
        }

        $this->view('games/index', compact('games', 'category'));
    }

    public function show(int $id): void {
        $game = Game::findWithAvailability($id);
        if (!$game) {
            $this->notFound();
            return;
        }
        $this->view('games/show', compact('game'));
    }

    public function create(): void {
        $this->requireAdmin();
        $this->view('games/create');
    }

    public function store(): void {
        $this->requireAdmin();

        $errors = [];
        $name     = trim($this->post('name', ''));
        $category = $this->post('category', '');
        $difficulty = (int) $this->post('difficulty', 0);
        $minPlayers = (int) $this->post('min_players', 0);
        $maxPlayers = (int) $this->post('max_players', 0);
        $copies = (int) $this->post('copies', 1);

        if (empty($name))
            $errors[] = 'Nom obligatoire.';
        if (!in_array($category, ['Stratégie', 'Ambiance', 'Famille', 'Experts']))
            $errors[] = 'Catégorie invalide.';
        if ($difficulty < 1 || $difficulty > 5)
            $errors[] = 'Difficulté doit être entre 1 et 5.';
        if ($minPlayers < 1 || $maxPlayers < $minPlayers)
            $errors[] = 'Nombre de joueurs invalide.';
        if ($copies < 1)
            $errors[] = 'Nombre d\'exemplaires invalide.';

        if (!empty($errors)) {
            $this->view('games/create', ['errors' => $errors]);
            return;
        }

        $pdo = \Core\Database::connect();
        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare('
                INSERT INTO games (name, category, description, difficulty, min_players, max_players, duration_minutes)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ');
            $stmt->execute([
                $name, $category, $this->post('description', ''),
                $difficulty, $minPlayers, $maxPlayers, (int) $this->post('duration_minutes', 0),
            ]);
            $gameId = (int) $pdo->lastInsertId();

            $copyStmt = $pdo->prepare('INSERT INTO game_copies (game_id, copy_number, status) VALUES (?, ?, ?)');
            for ($i = 1; $i <= $copies; $i++) {
                $copyStmt->execute([$gameId, $i, 'available']);
            }

            $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();
            $errors[] = 'Erreur lors de la création du jeu.';
            $this->view('games/create', ['errors' => $errors]);
            return;
        }

        $this->redirect('/games');
    }

    public function edit(int $id): void {
        $this->requireAdmin();
        $game = Game::findWithAvailability($id);
        if (!$game) $this->notFound();
        $this->view('games/edit', ['game' => $game]);
    }

    public function update(int $id): void {
        $this->requireAdmin();

        $errors = [];
        $name     = trim($this->post('name', ''));
        $category = $this->post('category', '');
        $difficulty = (int) $this->post('difficulty', 0);
        $minPlayers = (int) $this->post('min_players', 0);
        $maxPlayers = (int) $this->post('max_players', 0);

        if (empty($name))
            $errors[] = 'Nom obligatoire.';
        if (!in_array($category, ['Stratégie', 'Ambiance', 'Famille', 'Experts']))
            $errors[] = 'Catégorie invalide.';
        if ($difficulty < 1 || $difficulty > 5)
            $errors[] = 'Difficulté doit être entre 1 et 5.';
        if ($minPlayers < 1 || $maxPlayers < $minPlayers)
            $errors[] = 'Nombre de joueurs invalide.';

        if (!empty($errors)) {
            $game = Game::find($id);
            $this->view('games/edit', ['game' => $game, 'errors' => $errors]);
            return;
        }

        Game::update($id, [
            'name'             => $name,
            'category'         => $category,
            'description'      => $this->post('description', ''),
            'difficulty'       => $difficulty,
            'min_players'      => $minPlayers,
            'max_players'      => $maxPlayers,
            'duration_minutes' => (int) $this->post('duration_minutes', 0),
        ]);

        $this->redirect('/games/' . $id);
    }

    public function destroy(int $id): void {
        $this->requireAdmin();
        Game::delete($id);
        $this->redirect('/games');
    }

    public function addCopy(int $id): void {
        $this->requireAdmin();
        
        // Support both GET and POST
        $copies = (int) ($this->post('copies') ?? $this->get('copies', 1));

        if ($copies < 1) {
            $_SESSION['error'] = 'Nombre d\'exemplaires invalide.';
            $this->redirect('/games/' . $id . '/edit');
            return;
        }

        $game = Game::find($id);
        if (!$game) {
            $this->notFound();
            return;
        }

        $nextCopyNumber = GameCopy::getNextCopyNumber($id);
        for ($i = 0; $i < $copies; $i++) {
            GameCopy::create($id, $nextCopyNumber + $i);
        }

        $_SESSION['success'] = $copies . ' exemplaire(s) ajouté(s).';
        $this->redirect('/games/' . $id . '/edit');
    }
}