<main class="main-content">
    <a href="<?= BASE_URL ?>/games" class="back-link">
        <span class="material-icons">arrow_back</span>
        Retour au catalogue
    </a>

    <div class="game-detail-grid">
        <div class="game-detail-image">
            <?php if (!empty($game['image'])): ?>
                <img src="<?= htmlspecialchars($game['image']) ?>" alt="<?= htmlspecialchars($game['name']) ?>"/>
            <?php else: ?>
                <div style="width: 100%; height: 100%; background: var(--bg-card-hover); display: flex; align-items: center; justify-content: center;">
                    <span class="material-icons" style="font-size: 5rem; color: var(--text-muted);">casino</span>
                </div>
            <?php endif; ?>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div>
                <?php $available = (int) ($game['available_copies'] ?? 0); $total = (int) ($game['total_copies'] ?? 0); ?>
                <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1rem;">
                    <h1 style="font-size: 2rem; font-weight: 700; color: var(--text-primary);"><?= htmlspecialchars($game['name']) ?></h1>
                    <?php if ($total > 0): ?>
                        <?php if ($available > 0): ?>
                            <span class="badge badge-success">
                                <span class="material-icons" style="font-size: 0.875rem;">check_circle</span>
                                <?= $available == 1 ? '1 dispo' : $available.' dispo' ?>
                            </span>
                        <?php else: ?>
                            <span class="badge badge-warning">
                                <span class="material-icons" style="font-size: 0.875rem;">schedule</span>
                                En cours
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="badge badge-info">
                            <span class="material-icons" style="font-size: 0.875rem;">help</span>
                            Non dispo
                        </span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($game['description'])): ?>
                    <p style="color: var(--text-secondary); font-size: 1rem; line-height: 1.7;">
                        <?= htmlspecialchars($game['description']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="game-detail-stats">
                <div class="stat-card">
                    <div class="stat-card-icon">
                        <span class="material-icons">star</span>
                    </div>
                    <p class="stat-card-title">Difficulté</p>
                    <p class="stat-card-value">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="material-icons" style="<?= $i <= $game['difficulty'] ? 'color: var(--gold);' : 'opacity: 0.3;' ?>">star</span>
                        <?php endfor; ?>
                    </p>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">
                        <span class="material-icons">group</span>
                    </div>
                    <p class="stat-card-title">Joueurs</p>
                    <p class="stat-card-value"><?= $game['min_players'] ?> – <?= $game['max_players'] ?></p>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">
                        <span class="material-icons">schedule</span>
                    </div>
                    <p class="stat-card-title">Durée</p>
                    <p class="stat-card-value"><?= $game['duration_minutes'] ?> min</p>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">
                        <span class="material-icons">inventory_2</span>
                    </div>
                    <p class="stat-card-title">Exemplaires</p>
                    <p class="stat-card-value"><?= $total ?></p>
                </div>
            </div>

            <?php if (\Core\Controller::isAdmin()): ?>
            <div style="display: flex; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid var(--border); flex-wrap: wrap;">
                <a href="<?= BASE_URL ?>/games/<?= $game['id'] ?>/edit" class="btn btn-secondary" style="flex: 1; min-width: 150px;">
                    <span class="material-icons">edit</span>
                    Modifier
                </a>
                <form method="POST" action="<?= BASE_URL ?>/games/<?= $game['id'] ?>/delete" style="flex: 1;">
                    <button type="submit" class="btn btn-danger btn-block" style="width: 100%;" onclick="return confirm('Supprimer ce jeu ?');">
                        <span class="material-icons">delete</span>
                        Supprimer
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>