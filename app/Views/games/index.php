<main class="main-content">
    <div class="page-header">
        <h1 class="page-title">Catalogue</h1>
        <p class="page-subtitle">Découvrez notre collection</p>
    </div>

    <div class="category-filter">
        <a href="<?= BASE_URL ?>/games" class="category-btn <?= $category === null ? 'active' : '' ?>">Tous</a>
        <a href="<?= BASE_URL ?>/games?category=Stratégie" class="category-btn <?= $category === 'Stratégie' ? 'active' : '' ?>">Stratégie</a>
        <a href="<?= BASE_URL ?>/games?category=Ambiance" class="category-btn <?= $category === 'Ambiance' ? 'active' : '' ?>">Ambiance</a>
        <a href="<?= BASE_URL ?>/games?category=Famille" class="category-btn <?= $category === 'Famille' ? 'active' : '' ?>">Famille</a>
        <a href="<?= BASE_URL ?>/games?category=Experts" class="category-btn <?= $category === 'Experts' ? 'active' : '' ?>">Experts</a>
    </div>

    <?php if (\Core\Controller::isAdmin()): ?>
        <a href="<?= BASE_URL ?>/games/create" class="btn btn-primary" style="margin-bottom: 1.5rem;">
            <span class="material-icons">add</span>
            Ajouter un jeu
        </a>
    <?php endif; ?>

    <div class="games-grid">
        <?php if (empty($games)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <span class="material-icons">casino</span>
                </div>
                <h3 class="empty-title">Aucun jeu</h3>
                <p class="empty-text">Commencez par ajouter votre premier jeu</p>
                <?php if (\Core\Controller::isAdmin()): ?>
                    <a href="<?= BASE_URL ?>/games/create" class="btn btn-primary">
                        <span class="material-icons">add</span>
                        Ajouter un jeu
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($games as $game): ?>
                <article class="game-card">
                    <div class="game-image">
                        <?php if (!empty($game['image'])): ?>
                            <img src="<?= htmlspecialchars($game['image']) ?>" alt="<?= htmlspecialchars($game['name']) ?>">
                        <?php else: ?>
                            <div class="game-image-placeholder">
                                <span class="material-icons">casino</span>
                            </div>
                        <?php endif; ?>
                        <span class="game-category badge badge-gold"><?= htmlspecialchars($game['category']) ?></span>
                    </div>
                    <div class="game-content">
                        <h3 class="game-title"><?= htmlspecialchars($game['name']) ?></h3>
                        
                        <?php 
                        $available = (int) ($game['available_copies'] ?? 0);
                        $total = (int) ($game['total_copies'] ?? 0);
                        if ($total > 0): ?>
                            <?php if ($available > 0): ?>
                                <span class="badge badge-success" style="margin-bottom: 0.75rem;">
                                    <span class="material-icons" style="font-size: 0.875rem;">check_circle</span>
                                    <?= $available == 1 ? '1 dispo' : $available.' dispo' ?>
                                </span>
                            <?php else: ?>
                                <span class="badge badge-warning" style="margin-bottom: 0.75rem;">
                                    <span class="material-icons" style="font-size: 0.875rem;">schedule</span>
                                    En cours
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="badge badge-info" style="margin-bottom: 0.75rem;">Non dispo</span>
                        <?php endif; ?>
                        
                        <div class="game-meta">
                            <span class="game-meta-item">
                                <span class="material-icons" style="font-size: 1rem;">groups</span>
                                <?= $game['min_players'] ?>-<?= $game['max_players'] ?>
                            </span>
                            <span class="game-meta-item">
                                <span class="material-icons" style="font-size: 1rem;">schedule</span>
                                <?= $game['duration_minutes'] ?> min
                            </span>
                        </div>
                        
                        <a class="game-link" href="<?= BASE_URL ?>/games/<?= $game['id'] ?>">
                            Voir détails
                            <span class="material-icons" style="font-size: 1rem;">arrow_forward</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>