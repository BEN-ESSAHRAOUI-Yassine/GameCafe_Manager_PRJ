<main class="main-content" style="display: flex; justify-content: center; padding-top: 2rem;">
    <div class="card" style="max-width: 500px; width: 100%;">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div class="stat-chip" style="margin: 0 auto 1rem;">
                <span class="dot gold"></span>
                <span>Jeux</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Ajouter un nouveau jeu</h1>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Remplissez les informations du jeu</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="form-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?= BASE_URL ?>/games">
            <div class="form-group">
                <label class="form-label" for="name">Nom du jeu</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="Ex: Catan"/>
            </div>

            <div class="form-group">
                <label class="form-label" for="category">Catégorie</label>
                <select id="category" name="category" class="form-select">
                    <option value="Stratégie">Stratégie</option>
                    <option value="Ambiance">Ambiance</option>
                    <option value="Famille">Famille</option>
                    <option value="Experts">Experts</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-textarea" placeholder="Décrivez le jeu en quelques phrases..." rows="3"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="difficulty">Difficulté (1-5)</label>
                    <input type="number" id="difficulty" name="difficulty" class="form-input" min="1" max="5" placeholder="3"/>
                </div>
                <div class="form-group">
                    <label class="form-label" for="duration_minutes">Durée (min)</label>
                    <input type="number" id="duration_minutes" name="duration_minutes" class="form-input" placeholder="60"/>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="min_players">Joueurs min</label>
                    <input type="number" id="min_players" name="min_players" class="form-input" placeholder="2"/>
                </div>
                <div class="form-group">
                    <label class="form-label" for="max_players">Joueurs max</label>
                    <input type="number" id="max_players" name="max_players" class="form-input" placeholder="4"/>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="copies">Nombre d'exemplaires</label>
                <input type="number" id="copies" name="copies" class="form-input" min="1" value="1"/>
            </div>

            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>

            <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <span class="material-icons">add</span>
                    Ajouter le jeu
                </button>
                <a href="<?= BASE_URL ?>/games" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</main>