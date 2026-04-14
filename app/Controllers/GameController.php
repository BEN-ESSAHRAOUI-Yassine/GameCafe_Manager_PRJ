<?php

namespace App\Controllers;

use App\Models\Game;
use Core\Controller;

class GameController extends Controller {

    public function index(): void {
        $category = $_GET['category'] ?? null;
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
}