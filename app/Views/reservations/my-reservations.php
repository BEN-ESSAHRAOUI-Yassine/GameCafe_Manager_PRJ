<main class="main-content">
    <div class="page-header" style="margin-bottom: 1.5rem;">
        <div style="display: flex; flex-direction: column; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 1rem;">
            <div>
                <div class="stat-chip" style="margin-bottom: 1rem;">
                    <span class="dot gold"></span>
                    <span>Réservations</span>
                </div>
                <h1 class="page-title">Mes Réservations</h1>
                <p class="page-subtitle">Historique de vos réservations</p>
            </div>
            <a href="<?= BASE_URL ?>/reservations/create" class="btn btn-primary">
                <span class="material-icons">add_circle</span>
                Nouvelle Réservation
            </a>
        </div>
    </div>

    <?php if (!empty($reservations)): ?>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Table</th>
                        <th class="text-center">Durée</th>
                        <th class="text-center">Personnes</th>
                        <th>Statut</th>
                        <th class="text-center">Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td class="font-semibold"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($reservation['reserved_at']))) ?></td>
                            <td>
                                <span style="padding: 0.25rem 0.5rem; background: var(--bg-card-hover); border-radius: var(--radius-sm); font-size: 0.8125rem;">
                                    <?= htmlspecialchars($reservation['table_name'] ?? $reservation['table_id']) ?>
                                </span>
                            </td>
                            <td class="text-center"><?= $reservation['duration_hours'] ?? $reservation['duration'] ?? 1 ?>h</td>
                            <td class="text-center"><?= $reservation['party_size'] ?? $reservation['people_count'] ?? 1 ?></td>
                            <td>
                                <?php $status = $reservation['status'] ?? $reservation['reservation_status'] ?? 'pending'; ?>
                                <?php if ($status === 'pending'): ?>
                                    <span class="badge badge-warning">En attente</span>
                                <?php elseif ($status === 'confirmed'): ?>
                                    <span class="badge badge-info">Confirmée</span>
                                <?php elseif ($status === 'completed'): ?>
                                    <span class="badge badge-success">Complétée</span>
                                <?php elseif ($status === 'cancelled'): ?>
                                    <span class="badge badge-danger">Annulée</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= BASE_URL ?>/reservations/<?= $reservation['id'] ?>" class="btn btn-ghost btn-sm">
                                    <span class="material-icons">visibility</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">
                <span class="material-icons">event_busy</span>
            </div>
            <h3 class="empty-title">Aucune réservation</h3>
            <p class="empty-text">Réservez votre première table</p>
        </div>
    <?php endif; ?>
</main>