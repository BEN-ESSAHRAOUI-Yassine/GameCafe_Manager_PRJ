<main class="main-content" style="max-width: 600px; margin: 0 auto;">
    <a href="<?= BASE_URL ?>/reservations<?= \Core\Controller::isAdmin() ? '' : '/my-reservations' ?>" class="back-link">
        <span class="material-icons">arrow_back</span>
        Retour
    </a>

    <div class="card">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border);">
            <div style="width: 48px; height: 48px; background: var(--gold-muted); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <span class="material-icons" style="color: var(--gold);">event</span>
            </div>
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700;">Détails de la Réservation</h1>
                <p style="color: var(--text-muted); font-size: 0.875rem;">#<?= htmlspecialchars($reservation['id']) ?></p>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--text-secondary);">Statut</span>
                <?php if ($reservation['status'] === 'pending'): ?>
                    <span class="badge badge-warning">En attente</span>
                <?php elseif ($reservation['status'] === 'confirmed'): ?>
                    <span class="badge badge-info">Confirmée</span>
                <?php elseif ($reservation['status'] === 'completed'): ?>
                    <span class="badge badge-success">Complétée</span>
                <?php elseif ($reservation['status'] === 'cancelled'): ?>
                    <span class="badge badge-danger">Annulée</span>
                <?php endif; ?>
            </div>

            <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--text-secondary);">Client</span>
                <span style="font-weight: 600;"><?= htmlspecialchars($reservation['client_name'] ?? $reservation['user_name'] ?? 'Unknown') ?></span>
            </div>

            <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--text-secondary);">Table</span>
                <span style="font-weight: 600;">Table <?= htmlspecialchars($reservation['table_name'] ?? $reservation['table_id']) ?></span>
            </div>

            <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--text-secondary);">Date</span>
                <span style="font-weight: 600;"><?= htmlspecialchars(date('d/m/Y à H:i', strtotime($reservation['reserved_at']))) ?></span>
            </div>

            <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--text-secondary);">Durée</span>
                <span style="font-weight: 600;"><?= $reservation['duration_hours'] ?? $reservation['duration'] ?? 1 ?>h</span>
            </div>

            <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--text-secondary);">Personnes</span>
                <span style="font-weight: 600;"><?= $reservation['party_size'] ?? $reservation['people_count'] ?? 1 ?></span>
            </div>

            <?php if (!empty($reservation['notes'])): ?>
            <div style="padding: 0.75rem 0;">
                <span style="color: var(--text-secondary); display: block; margin-bottom: 0.5rem;">Notes</span>
                <p><?= htmlspecialchars($reservation['notes']) ?></p>
            </div>
            <?php endif; ?>
        </div>

        <?php if (\Core\Controller::isAdmin() && in_array($reservation['status'], ['pending', 'confirmed'])): ?>
        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
            <?php if ($reservation['status'] === 'pending'): ?>
                <form method="POST" action="<?= BASE_URL ?>/reservations/<?= $reservation['id'] ?>/status" style="flex: 1;">
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="btn btn-success btn-block">Confirmer</button>
                </form>
                <form method="POST" action="<?= BASE_URL ?>/reservations/<?= $reservation['id'] ?>/status" style="flex: 1;">
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-danger btn-block">Annuler</button>
                </form>
            <?php elseif ($reservation['status'] === 'confirmed'): ?>
                <form method="POST" action="<?= BASE_URL ?>/reservations/<?= $reservation['id'] ?>/status" style="flex: 1;">
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-danger btn-block">Annuler la réservation</button>
                </form>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</main>