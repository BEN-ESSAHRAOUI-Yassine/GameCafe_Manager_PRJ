<main class="min-h-screen pt-32 pb-24 px-4 md:px-8 max-w-7xl mx-auto relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>
    
    <div class="relative z-10">
        <header class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 rounded-full bg-primary/10 border border-primary/20">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-xs tracking-widest uppercase text-primary">Réservations</span>
                </div>
                <h1 class="font-headline text-4xl md:text-5xl font-extrabold tracking-tight text-on-surface mb-2">Mes Réservations</h1>
                <p class="text-on-surface-variant font-medium text-lg">Historique de vos réservations</p>
            </div>
            <a href="/reservations/create" class="inline-flex items-center gap-2 btn-primary px-6 py-3 rounded-xl font-bold hover:scale-105 transition-transform">
                <span class="material-symbols-outlined">add_circle</span>
                + Nouvelle Réservation
            </a>
        </header>

    <?php if (!empty($reservations)): ?>
    <div class="bg-surface-container-low rounded-xl overflow-hidden border border-outline-variant/15">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-high text-on-surface-variant font-headline uppercase text-xs tracking-widest">
                        <th class="px-8 py-5 font-bold">Date</th>
                        <th class="px-8 py-5 font-bold">Table</th>
                        <th class="px-8 py-5 font-bold">Durée</th>
                        <th class="px-8 py-5 font-bold">Personnes</th>
                        <th class="px-8 py-5 font-bold">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    <?php foreach ($reservations as $reservation): ?>
                        <tr class="hover:bg-surface-variant transition-colors group">
                            <td class="px-8 py-6 font-semibold text-on-surface">
                                <?= htmlspecialchars(date('d/m/Y H:i', strtotime($reservation['reserved_at']))) ?>
                            </td>
                            <td class="px-8 py-6">
                                <span class="bg-surface-container-highest px-3 py-1 rounded text-sm font-medium border border-outline-variant/20">Table <?= htmlspecialchars($reservation['table_name'] ?? $reservation['table_id']) ?></span>
                            </td>
                            <td class="px-8 py-6 font-medium text-on-surface-variant"><?= $reservation['duration_hours'] ?? $reservation['duration'] ?>h</td>
                            <td class="px-8 py-6 font-medium text-on-surface-variant"><?= $reservation['party_size'] ?? $reservation['people_count'] ?> personnes</td>
                            <td class="px-8 py-6">
                                <?php if (($reservation['status'] ?? $reservation['reservation_status']) === 'pending'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                        En attente
                                    </span>
                                <?php elseif (($reservation['status'] ?? $reservation['reservation_status']) === 'confirmed'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        Confirmée
                                    </span>
                                <?php elseif (($reservation['status'] ?? $reservation['reservation_status']) === 'completed'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                        Complétée
                                    </span>
                                <?php elseif (($reservation['status'] ?? $reservation['reservation_status']) === 'cancelled'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-error/10 text-error border border-error/20">
                                        Annulée
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center py-20">
        <span class="material-symbols-outlined text-6xl text-on-surface-variant mb-4">event_busy</span>
        <p class="text-on-surface-variant text-lg">Aucune réservation trouvée.</p>
        <a href="/reservations/create" class="text-primary font-bold mt-4 inline-block">Créer une réservation</a>
    </div>
    <?php endif; ?>
    </div>
</main>