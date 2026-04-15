<main class="pt-32 pb-24 px-4 md:px-8 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>

    <div class="max-w-7xl relative z-10">
        <div class="mb-12 relative overflow-hidden rounded-xl bg-surface-container-low p-10 border border-outline-variant/15">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 rounded-full bg-primary/10 border border-primary/20">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-xs tracking-widest uppercase text-primary">Réservations</span>
                </div>
                <h1 class="text-5xl font-extrabold tracking-tighter text-on-surface mb-2">Gestion des Réservations</h1>
                <p class="text-on-surface-variant text-lg font-medium opacity-80">Toutes les réservations</p>
            </div>
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute right-10 bottom-0 opacity-10 pointer-events-none">
                <span class="material-symbols-outlined !text-[160px]">calendar_today</span>
            </div>
        </div>

    <div class="bg-surface-container-low rounded-xl overflow-hidden border border-outline-variant/15">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-high/50 border-b border-outline-variant/20">
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Client</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Table</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Date &amp; Heure</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-center">Durée</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-center">Personnes</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Statut</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-center">Détails</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    <?php foreach ($reservations as $reservation): ?>
                        <tr class="hover:bg-surface-container-highest/30 transition-colors group">
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                        <?= strtoupper(substr($reservation['client_name'] ?? $reservation['user_name'] ?? 'U', 0, 2)) ?>
                                    </div>
                                    <span class="font-bold text-on-surface"><?= htmlspecialchars($reservation['client_name'] ?? $reservation['user_name'] ?? 'Unknown') ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-on-surface-variant font-medium">Table <?= htmlspecialchars($reservation['table_name'] ?? $reservation['table'] ?? $reservation['table_id']) ?></td>
                            <td class="px-6 py-6 text-on-surface-variant"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($reservation['reserved_at'] ?? $reservation['date']))) ?></td>
                            <td class="px-6 py-6 text-center text-on-surface-variant"><?= $reservation['duration_hours'] ?? $reservation['duration'] ?? 1 ?>h</td>
                            <td class="px-6 py-6 text-center text-on-surface-variant"><?= $reservation['party_size'] ?? $reservation['people_count'] ?? 1 ?></td>
                            <td class="px-6 py-6">
                                <?php if ($reservation['status'] === 'pending'): ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">En attente</span>
                                <?php elseif ($reservation['status'] === 'confirmed'): ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-500/10 text-blue-400 border border-blue-500/20">Confirmée</span>
                                <?php elseif ($reservation['status'] === 'completed'): ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-zinc-500/10 text-zinc-400 border border-zinc-500/20">Complétée</span>
                                <?php elseif ($reservation['status'] === 'cancelled'): ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-red-500/10 text-red-500 border border-red-500/20">Annulée</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <a href="/reservations/<?= $reservation['id'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container-high hover:bg-surface-variant text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                            </td>
                            <td class="px-6 py-6 text-right">
                                <?php if ($reservation['status'] === 'pending'): ?>
                                    <form method="POST" action="/reservations/<?= $reservation['id'] ?>/status" class="inline">
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-500 px-3 py-1.5 rounded-lg text-xs font-bold transition-all border border-emerald-500/20">Confirmer</button>
                                    </form>
                                    <form method="POST" action="/reservations/<?= $reservation['id'] ?>/status" class="inline ml-2">
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="bg-transparent hover:bg-red-500/10 text-red-400 border border-red-500/20 px-3 py-1.5 rounded-lg text-xs font-bold transition-all">Annuler</button>
                                    </form>
                                <?php elseif ($reservation['status'] === 'confirmed'): ?>
                                    <form method="POST" action="/reservations/<?= $reservation['id'] ?>/status" class="inline">
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="bg-transparent hover:bg-red-500/10 text-red-400 border border-red-500/20 px-3 py-1.5 rounded-lg text-xs font-bold transition-all">Annuler</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-surface-container-high/30 border-t border-outline-variant/10 flex justify-between items-center">
            <p class="text-xs text-on-surface-variant font-medium">Affichage de <?= count($reservations) ?> réservations</p>
        </div>
    </div>
</main>