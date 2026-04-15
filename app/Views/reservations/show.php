<main class="pt-32 pb-24 px-4 md:px-8 max-w-3xl relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>
    
    <div class="relative z-10">
        <a href="/reservations<?= \Core\Controller::isAdmin() ? '' : '/my-reservations' ?>" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors mb-8">
            <span class="material-symbols-outlined">arrow_back</span>
            Retour
        </a>

        <div class="bg-surface-container-low rounded-xl overflow-hidden border border-outline-variant/15 p-8 md:p-10">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">event</span>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-headline font-bold text-on-surface">Détails de la Réservation</h1>
                    <p class="text-on-surface-variant text-sm">#<?= htmlspecialchars($reservation['id']) ?></p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex justify-between items-center py-4 border-b border-outline-variant/10">
                    <span class="text-on-surface-variant">Statut</span>
                    <?php if ($reservation['status'] === 'pending'): ?>
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">En attente</span>
                    <?php elseif ($reservation['status'] === 'confirmed'): ?>
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">Confirmée</span>
                    <?php elseif ($reservation['status'] === 'completed'): ?>
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-gray-500/10 text-gray-400 border border-gray-500/20">Complétée</span>
                    <?php elseif ($reservation['status'] === 'cancelled'): ?>
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-red-500/10 text-red-500 border border-red-500/20">Annulée</span>
                    <?php endif; ?>
                </div>

                <div class="flex justify-between items-center py-4 border-b border-outline-variant/10">
                    <span class="text-on-surface-variant">Client</span>
                    <span class="font-semibold text-on-surface"><?= htmlspecialchars($reservation['client_name'] ?? $reservation['user_name'] ?? 'Unknown') ?></span>
                </div>

                <div class="flex justify-between items-center py-4 border-b border-outline-variant/10">
                    <span class="text-on-surface-variant">Table</span>
                    <span class="font-semibold text-on-surface">Table <?= htmlspecialchars($reservation['table_name'] ?? $reservation['table_id']) ?></span>
                </div>

                <div class="flex justify-between items-center py-4 border-b border-outline-variant/10">
                    <span class="text-on-surface-variant">Date et Heure</span>
                    <span class="font-semibold text-on-surface"><?= htmlspecialchars(date('d/m/Y à H:i', strtotime($reservation['reserved_at']))) ?></span>
                </div>

                <div class="flex justify-between items-center py-4 border-b border-outline-variant/10">
                    <span class="text-on-surface-variant">Durée</span>
                    <span class="font-semibold text-on-surface"><?= $reservation['duration_hours'] ?? $reservation['duration'] ?? 1 ?>h</span>
                </div>

                <div class="flex justify-between items-center py-4 border-b border-outline-variant/10">
                    <span class="text-on-surface-variant">Nombre de personnes</span>
                    <span class="font-semibold text-on-surface"><?= $reservation['party_size'] ?? $reservation['people_count'] ?? 1 ?> personnes</span>
                </div>

                <?php if (!empty($reservation['notes'])): ?>
                <div class="py-4 border-b border-outline-variant/10">
                    <span class="text-on-surface-variant block mb-2">Notes</span>
                    <p class="text-on-surface"><?= htmlspecialchars($reservation['notes']) ?></p>
                </div>
                <?php endif; ?>
            </div>

            <?php if (\Core\Controller::isAdmin() && in_array($reservation['status'], ['pending', 'confirmed'])): ?>
            <div class="mt-8 pt-6 border-t border-outline-variant/10 flex gap-3">
                <?php if ($reservation['status'] === 'pending'): ?>
                    <form method="POST" action="/reservations/<?= $reservation['id'] ?>/status" class="flex-1">
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-3 rounded-lg font-bold transition-all">Confirmer</button>
                    </form>
                    <form method="POST" action="/reservations/<?= $reservation['id'] ?>/status" class="flex-1">
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="w-full bg-transparent hover:bg-red-500/10 text-red-400 border border-red-500/20 px-4 py-3 rounded-lg font-bold transition-all">Annuler</button>
                    </form>
                <?php elseif ($reservation['status'] === 'confirmed'): ?>
                    <form method="POST" action="/reservations/<?= $reservation['id'] ?>/status" class="flex-1">
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="w-full bg-transparent hover:bg-red-500/10 text-red-400 border border-red-500/20 px-4 py-3 rounded-lg font-bold transition-all">Annuler la réservation</button>
                    </form>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>