<?php

namespace App\Controllers;

use App\Models\Game;
use Core\Controller;

class GameController extends Controller {

    public function index(): void {
        $category = $this->get('category');
        $validCategories = ['Stratégie', 'Ambiance', 'Famille', 'Experts'];

        if ($category && in_array($category, $validCategories)) {
            $games = Game::allByCategory($category);
        } else {
            $games = Game::all();
            $category = null;
        }

        $this->view('games/index', compact('games', 'category'));
    }

    public function show(int $id): void {
        $game = Game::find($id);
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

        if (empty($name))
            $errors[] = 'Nom obligatoire.';
        if (!in_array($category, ['Stratégie', 'Ambiance', 'Famille', 'Experts']))
            $errors[] = 'Catégorie invalide.';
        if ($difficulty < 1 || $difficulty > 5)
            $errors[] = 'Difficulté doit être entre 1 et 5.';
        if ($minPlayers < 1 || $maxPlayers < $minPlayers)
            $errors[] = 'Nombre de joueurs invalide.';

        if (!empty($errors)) {
            $this->view('games/create', ['errors' => $errors]);
            return;
        }

        Game::insert([
            'name'             => $name,
            'category'         => $category,
            'description'      => $this->post('description', ''),
            'difficulty'       => $difficulty,
            'min_players'      => $minPlayers,
            'max_players'      => $maxPlayers,
            'duration_minutes' => (int) $this->post('duration_minutes', 0),
        ]);

        $this->redirect('/games');
    }

    public function edit(int $id): void {
        $this->requireAdmin();
        $game = Game::find($id);
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
}