<main class="main-content">
    <div class="page-header">
        <header style="display: flex; flex-direction: column; align-items: flex-end; justify-content: space-between; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <div class="stat-chip" style="margin-bottom: 1rem;">
                    <span class="dot gold"></span>
                    <span>Sessions</span>
                </div>
                <h1 class="page-title">Historique</h1>
                <p class="page-subtitle">Toutes les sessions terminées</p>
            </div>
            <div class="stat-card" style="padding: 1rem; border-left: 3px solid var(--gold);">
                <p style="font-size: 0.6875rem; color: var(--gold); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Total</p>
                <p style="font-size: 1.5rem; font-weight: 700;"><?= count($sessions ?? []) ?></p>
            </div>
        </header>

    <?php if (!empty($sessions)): ?>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Jeu</th>
                        <th>Table</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th class="text-right">Durée</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sessions as $session): ?>
                        <tr>
                            <td>
                                <div class="table-user">
                                    <div class="table-user-avatar">
                                        <?= strtoupper(substr($session['client_name'] ?? $session['user_name'] ?? 'U', 0, 2)) ?>
                                    </div>
                                    <span class="font-semibold"><?= htmlspecialchars($session['client_name'] ?? $session['user_name'] ?? 'Unknown') ?></span>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span class="material-icons" style="color: var(--gold); font-size: 1rem;">casino</span>
                                    <span><?= htmlspecialchars($session['game_name'] ?? $session['game']) ?></span>
                                </div>
                            </td>
                            <td>
                                <span style="padding: 0.25rem 0.5rem; background: var(--bg-card-hover); border-radius: var(--radius-sm); font-size: 0.8125rem;">
                                    <?= htmlspecialchars($session['table_name'] ?? $session['table']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars(date('d/m H:i', strtotime($session['started_at'] ?? $session['start_date']))) ?></td>
                            <td><?= htmlspecialchars(date('d/m H:i', strtotime($session['ended_at'] ?? $session['end_date']))) ?></td>
                            <td class="text-right">
                                <span class="badge badge-gold">
                                    <?= $session['duration_minutes'] ?? $session['duration_hours'] ?? $session['duration'] ?? 0 ?> min
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">
                <span class="material-icons">history</span>
            </div>
            <h3 class="empty-title">Aucune session</h3>
            <p class="empty-text">Les sessions terminées apparaîtront ici</p>
            <a href="<?= BASE_URL ?>/sessions/dashboard" class="btn btn-primary">
                <span class="material-icons">dashboard</span>
                Dashboard
            </a>
        </div>
    <?php endif; ?>
    </div>
</main>