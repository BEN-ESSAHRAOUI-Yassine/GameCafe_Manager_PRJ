<?php

namespace App\Controllers;

use App\Models\Game;

class GameController {

    public function index(): void {
        $category = $_GET['category'] ?? null;
        $validCategories = ['Stratégie', 'Ambiance', 'Famille', 'Experts'];

        if ($category && in_array($category, $validCategories)) {
            $games = Game::allByCategory($category);
        } else {
            $games = Game::all();
            $category = null;
        }

        require __DIR__ . '/../Views/games/index.php';
    }

    public function show(int $id): void {
        $game = Game::find($id);
        if (!$game) {
            http_response_code(404);
            echo '<h1>Jeu introuvable</h1>';
            return;
        }
        require __DIR__ . '/../Views/games/show.php';
    }
}