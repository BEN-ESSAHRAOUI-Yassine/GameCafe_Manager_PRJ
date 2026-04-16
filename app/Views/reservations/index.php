<main class="main-content">
    <div class="page-header">
        <div class="flex items-center gap-3 mb-2">
            <span class="dot gold"></span>
            <h1 class="page-title">Réservations</h1>
        </div>
        <p class="page-subtitle">Gestion des réservations</p>
    </div>

    <div class="table-container">
        <?php if (empty($reservations)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <span class="material-icons">event_busy</span>
                </div>
                <h3 class="empty-title">Aucune réservation</h3>
                <p class="empty-text">Les réservations apparaîtront ici</p>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Table</th>
                        <th>Date</th>
                        <th class="text-center">Durée</th>
                        <th class="text-center">Personnes</th>
                        <th>Statut</th>
                        <th class="text-center">Détails</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td>
                                <div class="table-user">
                                    <div class="table-user-avatar">
                                        <?= strtoupper(substr($reservation['client_name'] ?? $reservation['user_name'] ?? 'U', 0, 2)) ?>
                                    </div>
                                    <span class="font-semibold"><?= htmlspecialchars($reservation['client_name'] ?? $reservation['user_name'] ?? 'Unknown') ?></span>
                                </div>
                            </td>
                            <td>
                                <span style="padding: 0.25rem 0.5rem; background: var(--bg-card-hover); border-radius: var(--radius-sm); font-size: 0.8125rem;">
                                    <?= htmlspecialchars($reservation['table_name'] ?? $reservation['table'] ?? $reservation['table_id']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($reservation['reserved_at'] ?? $reservation['date']))) ?></td>
                            <td class="text-center"><?= $reservation['duration_hours'] ?? $reservation['duration'] ?? 1 ?>h</td>
                            <td class="text-center"><?= $reservation['party_size'] ?? $reservation['people_count'] ?? 1 ?></td>
                            <td>
                                <?php if ($reservation['status'] === 'pending'): ?>
                                    <span class="badge badge-warning">En attente</span>
                                <?php elseif ($reservation['status'] === 'confirmed'): ?>
                                    <span class="badge badge-info">Confirmée</span>
                                <?php elseif ($reservation['status'] === 'completed'): ?>
                                    <span class="badge badge-success">Complétée</span>
                                <?php elseif ($reservation['status'] === 'cancelled'): ?>
                                    <span class="badge badge-danger">Annulée</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= BASE_URL ?>/reservations/<?= $reservation['id'] ?>" class="btn btn-ghost btn-sm">
                                    <span class="material-icons">visibility</span>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <?php if ($reservation['status'] === 'pending'): ?>
                                        <form method="POST" action="<?= BASE_URL ?>/reservations/<?= $reservation['id'] ?>/status">
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-success btn-sm">Confirmer</button>
                                        </form>
                                        <form method="POST" action="<?= BASE_URL ?>/reservations/<?= $reservation['id'] ?>/status">
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
                                        </form>
                                    <?php elseif ($reservation['status'] === 'confirmed'): ?>
                                        <form method="POST" action="<?= BASE_URL ?>/reservations/<?= $reservation['id'] ?>/status">
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="padding: 0.75rem 1rem; background: var(--bg-card-hover); border-top: 1px solid var(--border); display: flex; justify-content: space-between;">
                <p style="font-size: 0.75rem; color: var(--text-muted);"><?= count($reservations) ?> réservation(s)</p>
            </div>
        <?php endif; ?>
    </div>
</main>