<main class="main-content">
    <div class="page-header">
        <div class="flex items-center gap-3 mb-4">
            <span class="dot green"></span>
            <h1 class="page-title">Sessions Actives</h1>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-bar">
            <div class="stat-card" style="padding: 1rem 1.5rem; border-left: 3px solid var(--gold);">
                <p style="font-size: 0.6875rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Total Tables</p>
                <p style="font-size: 1.5rem; font-weight: 700;"><?= count($tables ?? []) ?></p>
            </div>
            <div class="stat-card" style="padding: 1rem 1.5rem; border-left: 3px solid var(--green);">
                <p style="font-size: 0.6875rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Disponibles</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: var(--green-light);"><?= count(array_filter($tables ?? [], fn($t) => empty($t['session_id']))) ?></p>
            </div>
            <div class="stat-card" style="padding: 1rem 1.5rem; border-left: 3px solid var(--red);">
                <p style="font-size: 0.6875rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Occupées</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: var(--red-light);"><?= count(array_filter($tables ?? [], fn($t) => !empty($t['session_id']))) ?></p>
            </div>
        </div>
    </div>

    <?php if (empty($tables)): ?>
        <div class="empty-state">
            <div class="empty-icon">
                <span class="material-icons">table_restaurant</span>
            </div>
            <h3 class="empty-title">Aucune table</h3>
            <p class="empty-text">Les tables apparaîtront ici</p>
            <a href="<?= BASE_URL ?>/sessions/create" class="btn btn-primary">
                <span class="material-icons">add</span>
                Démarrer une session
            </a>
        </div>
    <?php else: ?>
        <div class="cards-grid">
            <?php foreach ($tables as $table): ?>
                <?php if (!empty($table['session_id'])): ?>
                    <div class="card card-table <?= !empty($table['overtime']) ? 'overtime' : 'occupied' ?>">
                        <div class="card-table-header">
                            <div>
                                <?php if (!empty($table['overtime'])): ?>
                                    <span class="badge badge-danger">
                                        <span class="animate-pulse">⚠️</span> Dépassée
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Occupée</span>
                                <?php endif; ?>
                                <h2 class="card-table-title" style="margin-top: 0.5rem;">
                                    <?= htmlspecialchars($table['name'] ?? $table['number'] ?? $table['id']) ?>
                                </h2>
                            </div>
                            <div class="material-icons" style="color: var(--gold); font-size: 1.5rem;">casino</div>
                        </div>
                        
                        <div style="padding: 0.5rem 0;">
                            <div class="flex justify-between text-sm" style="margin-bottom: 0.75rem;">
                                <div>
                                    <p class="info-label" style="text-align: left;">Jeu</p>
                                    <p class="font-semibold"><?= htmlspecialchars($table['game_name'] ?? 'Jeu') ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="info-label" style="text-align: right;">Client</p>
                                    <p class="font-semibold"><?= htmlspecialchars($table['client_name'] ?? $table['user_name'] ?? 'Client') ?></p>
                                </div>
                            </div>
                            
                            <?php if (!empty($table['overtime'])): ?>
                                <div style="background: var(--red-muted); padding: 0.75rem; border-radius: var(--radius-md); display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <p class="info-label" style="text-align: left; color: var(--red-light);">Temps dépassé</p>
                                        <p class="font-bold" style="color: var(--red-light); font-size: 1.25rem;"><?= $table['overtime'] ?> min</p>
                                    </div>
                                    <span class="material-icons" style="color: var(--red-light); font-size: 1.5rem; animation: pulse 1s infinite;">warning</span>
                                </div>
                            <?php else: ?>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <p class="info-label">Début</p>
                                        <p class="info-value"><?= htmlspecialchars(date('H:i', strtotime($table['started_at'] ?? $table['start_time'] ?? 'now'))) ?></p>
                                    </div>
                                    <div class="info-item">
                                        <p class="info-label">Durée</p>
                                        <p class="info-value"><?= $table['duration_hours'] ?? $table['duration'] ?? 1 ?>h</p>
                                    </div>
                                    <div class="info-item">
                                        <p class="info-label">Écoulé</p>
                                        <p class="info-value gold"><?= $table['elapsed_minutes'] ?? $table['elapsed'] ?? 0 ?>m</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <form method="POST" action="<?= BASE_URL ?>/sessions/<?= $table['session_id'] ?>/end" onsubmit="return confirm('Terminer cette session ?');">
                            <button type="submit" class="btn btn-danger btn-block">
                                <span class="material-icons">stop</span>
                                Terminer
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="card card-table available">
                        <div class="card-table-header">
                            <div>
                                <span class="badge badge-success">Disponible</span>
                                <h2 class="card-table-title muted" style="margin-top: 0.5rem;">
                                    <?= htmlspecialchars($table['name'] ?? $table['number'] ?? $table['id']) ?>
                                </h2>
                            </div>
                            <div class="material-icons" style="color: var(--text-muted); font-size: 1.5rem;">table_restaurant</div>
                        </div>
                        
                        <a href="<?= BASE_URL ?>/sessions/create" class="btn btn-primary btn-block">
                            <span class="material-icons">play_arrow</span>
                            Démarrer
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>