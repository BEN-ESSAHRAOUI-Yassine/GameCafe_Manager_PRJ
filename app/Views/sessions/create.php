<main class="main-content" style="display: flex; justify-content: center; padding-top: 2rem;">
    <div class="card" style="max-width: 450px; width: 100%;">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div class="stat-chip" style="margin: 0 auto 1rem;">
                <span class="dot green"></span>
                <span>Sessions</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Démarrer une session</h1>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Associer une réservation à un jeu</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="form-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($reservations ?? $availableReservations ?? [])): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <span class="material-icons">event_busy</span>
                </div>
                <p style="color: var(--text-secondary); margin-bottom: 1rem;">Aucune réservation confirmée disponible</p>
                <a href="<?= BASE_URL ?>/sessions/dashboard" class="btn btn-primary">Retour au dashboard</a>
            </div>
        <?php else: ?>
            <form method="POST" action="<?= BASE_URL ?>/sessions">
                <div class="form-group">
                    <label class="form-label" for="reservation_id">Réservation</label>
                    <select id="reservation_id" name="reservation_id" class="form-select">
                        <?php foreach ($reservations ?? $availableReservations ?? [] as $res): ?>
                            <option value="<?= $res['id'] ?>">
                                <?= htmlspecialchars($res['client_name'] ?? $res['user_name'] ?? 'Client') ?> — 
                                Table <?= htmlspecialchars($res['table_name'] ?? $res['table']) ?> — 
                                <?= htmlspecialchars(date('d/m H:i', strtotime($res['reserved_at'] ?? $res['date']))) ?> 
                                (<?= $res['duration_hours'] ?? $res['duration'] ?? 1 ?>h, <?= $res['party_size'] ?? $res['people_count'] ?? 1 ?> pers.)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="game_id">Jeu</label>
                    <select id="game_id" name="game_id" class="form-select">
                        <?php foreach ($games ?? $availableGames ?? [] as $game): ?>
                            <option value="<?= $game['id'] ?>"><?= htmlspecialchars($game['name']) ?> (<?= htmlspecialchars($game['category']) ?> · <?= $game['min_players'] ?>-<?= $game['max_players'] ?> joueurs)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if (!empty($_SESSION['csrf_token'])): ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php endif; ?>

                <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <span class="material-icons">play_arrow</span>
                        Démarrer
                    </button>
                    <a href="<?= BASE_URL ?>/sessions/dashboard" class="btn btn-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</main>