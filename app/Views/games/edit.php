<main class="main-content" style="display: flex; justify-content: center; padding-top: 2rem;">
    <?php $gameId = $game['id']; ?>
    <div class="card" style="max-width: 500px; width: 100%;">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div class="stat-chip" style="margin: 0 auto 1rem;">
                <span class="dot gold"></span>
                <span>Jeux</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Modifier le jeu</h1>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Mettre à jour les informations</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="form-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div style="background: var(--green-muted); border: 1px solid var(--green); border-radius: var(--radius-md); padding: 0.75rem; margin-bottom: 1rem; color: var(--green-light); font-size: 0.875rem;">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <!-- Form to add copies -->
        <form method="POST" action="<?= BASE_URL ?>/games/<?= $gameId ?>/add-copy" style="margin-bottom: 1.5rem; padding: 1rem; background: var(--bg-card-hover); border-radius: var(--radius-md);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0;">
                        Exemplaires: <strong><?= (int)($game['total_copies'] ?? 0) ?></strong>
                    </p>
                </div>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <input type="number" name="copies" class="form-input" min="1" max="10" value="1" style="width: 70px; padding: 0.5rem;"/>
                    <button type="submit" class="btn btn-success btn-sm">Ajouter</button>
                </div>
            </div>
        </form>
        
        <!-- Main form to update game -->
        <form method="POST" action="<?= BASE_URL ?>/games/<?= $gameId ?>/update">
            <div class="form-group">
                <label class="form-label" for="name">Nom du jeu</label>
                <input type="text" id="name" name="name" class="form-input" value="<?= htmlspecialchars($game['name'] ?? '') ?>"/>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="category">Catégorie</label>
                <select id="category" name="category" class="form-select">
                    <option value="Stratégie" <?= ($game['category'] ?? '') === 'Stratégie' ? 'selected' : '' ?>>Stratégie</option>
                    <option value="Famille" <?= ($game['category'] ?? '') === 'Famille' ? 'selected' : '' ?>>Famille</option>
                    <option value="Ambiance" <?= ($game['category'] ?? '') === 'Ambiance' ? 'selected' : '' ?>>Ambiance</option>
                    <option value="Experts" <?= ($game['category'] ?? '') === 'Experts' ? 'selected' : '' ?>>Experts</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-textarea" rows="3"><?= htmlspecialchars($game['description'] ?? '') ?></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="difficulty">Difficulté</label>
                    <div style="display: flex; align-items: center; gap: 0.75rem; background: var(--bg-input); padding: 0.75rem; border-radius: var(--radius-md);">
                        <input type="range" name="difficulty" min="1" max="5" value="<?= $game['difficulty'] ?? 3 ?>" style="flex: 1; accent-color: var(--gold);"/>
                        <span style="color: var(--gold); font-weight: 700; min-width: 20px; text-align: center;"><?= $game['difficulty'] ?? 3 ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="duration_minutes">Durée (min)</label>
                    <input type="number" id="duration_minutes" name="duration_minutes" class="form-input" value="<?= $game['duration_minutes'] ?? 60 ?>"/>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="min_players">Joueurs min</label>
                    <input type="number" id="min_players" name="min_players" class="form-input" value="<?= $game['min_players'] ?? 2 ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label" for="max_players">Joueurs max</label>
                    <input type="number" id="max_players" name="max_players" class="form-input" value="<?= $game['max_players'] ?? 4 ?>"/>
                </div>
            </div>
            
            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>

            <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <span class="material-icons">save</span>
                    Enregistrer
                </button>
                <a href="<?= BASE_URL ?>/games/<?= $gameId ?>" class="btn btn-danger">
                    <span class="material-icons">close</span>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</main>