<main class="pt-32 pb-20 px-8 max-w-[1920px] mx-auto">
    <header class="mb-12 relative">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-5xl md:text-6xl font-black font-headline tracking-tighter text-on-surface mb-2">
                    Historique des <span class="text-primary">Sessions</span>
                </h1>
                <p class="text-on-surface-variant font-body text-lg max-w-2xl">
                    Toutes les sessions terminées
                </p>
            </div>
            <div class="bg-surface-container-low p-6 rounded-xl border-l-4 border-primary self-start">
                <span class="block text-label-sm text-primary mb-1 uppercase tracking-widest font-bold">Volume Total</span>
                <span class="text-3xl font-headline font-bold"><?= count($sessions ?? []) ?> Sessions</span>
            </div>
        </div>
    </header>

    <?php if (!empty($sessions)): ?>
    <div class="bg-surface-container-low rounded-3xl overflow-hidden shadow-2xl border border-white/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-high border-b border-white/5">
                        <th class="px-8 py-5 text-sm font-bold text-outline uppercase tracking-widest">Client</th>
                        <th class="px-6 py-5 text-sm font-bold text-outline uppercase tracking-widest">Jeu</th>
                        <th class="px-6 py-5 text-sm font-bold text-outline uppercase tracking-widest">Table</th>
                        <th class="px-6 py-5 text-sm font-bold text-outline uppercase tracking-widest">Début</th>
                        <th class="px-6 py-5 text-sm font-bold text-outline uppercase tracking-widest">Fin</th>
                        <th class="px-8 py-5 text-sm font-bold text-outline uppercase tracking-widest text-right">Durée</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($sessions as $session): ?>
                        <tr class="hover:bg-surface-container-high transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                        <?= strtoupper(substr($session['client_name'] ?? $session['user_name'] ?? 'U', 0, 2)) ?>
                                    </div>
                                    <span class="font-bold text-on-surface"><?= htmlspecialchars($session['client_name'] ?? $session['user_name'] ?? 'Unknown') ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center space-x-2">
                                    <span class="material-symbols-outlined text-outline">casino</span>
                                    <span class="text-on-surface-variant font-medium"><?= htmlspecialchars($session['game_name'] ?? $session['game']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="bg-surface-container-highest px-3 py-1 rounded-md text-sm border border-white/5">Table <?= htmlspecialchars($session['table_name'] ?? $session['table']) ?></span>
                            </td>
                            <td class="px-6 py-6 text-on-surface-variant font-mono"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($session['started_at'] ?? $session['start_date']))) ?></td>
                            <td class="px-6 py-6 text-on-surface-variant font-mono"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($session['ended_at'] ?? $session['end_date']))) ?></td>
                            <td class="px-8 py-6 text-right">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-[#d4af37]/10 text-[#d4af37] border border-[#d4af37]/20">
                                    <?= $session['duration_minutes'] ?? $session['duration_hours'] ?? $session['duration'] ?? 0 ?> min
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center py-20">
        <span class="material-symbols-outlined text-6xl text-on-surface-variant mb-4">history</span>
        <p class="text-on-surface-variant text-lg">Aucune session terminée.</p>
        <a href="/sessions/dashboard" class="text-primary font-bold mt-4 inline-block">Voir le dashboard</a>
    </div>
    <?php endif; ?>
</main>