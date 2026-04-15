<main class="pt-32 pb-20 px-8 max-w-[1920px] relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>
    
    <div class="relative z-10">
        <header class="mb-12 relative">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 rounded-full bg-primary/10 border border-primary/20">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        <span class="text-xs tracking-widest uppercase text-primary">Sessions</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black font-headline tracking-tighter text-on-surface mb-2">
                        Historique des Sessions
                    </h1>
                    <p class="text-on-surface-variant font-body text-lg max-w-2xl">
                        Toutes les sessions terminées
                    </p>
                </div>
                <div class="bg-surface-container-low p-6 rounded-xl border-l-4 border-primary self-start">
                    <span class="block text-xs text-primary mb-1 uppercase tracking-widest font-bold">Volume Total</span>
                    <span class="text-3xl font-headline font-bold"><?= count($sessions ?? []) ?> Sessions</span>
                </div>
            </div>
        </header>

    <?php if (!empty($sessions)): ?>
    <div class="bg-surface-container-low rounded-3xl overflow-hidden border border-outline-variant/15">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-high border-b border-outline-variant/20">
                        <th class="px-8 py-5 text-sm font-bold uppercase tracking-widest text-on-surface-variant">Client</th>
                        <th class="px-6 py-5 text-sm font-bold uppercase tracking-widest text-on-surface-variant">Jeu</th>
                        <th class="px-6 py-5 text-sm font-bold uppercase tracking-widest text-on-surface-variant">Table</th>
                        <th class="px-6 py-5 text-sm font-bold uppercase tracking-widest text-on-surface-variant">Début</th>
                        <th class="px-6 py-5 text-sm font-bold uppercase tracking-widest text-on-surface-variant">Fin</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase tracking-widest text-on-surface-variant text-right">Durée</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
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
                                    <span class="material-symbols-outlined text-primary">casino</span>
                                    <span class="text-on-surface-variant font-medium"><?= htmlspecialchars($session['game_name'] ?? $session['game']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="bg-surface-container-highest px-3 py-1 rounded-md text-sm border border-outline-variant/20">Table <?= htmlspecialchars($session['table_name'] ?? $session['table']) ?></span>
                            </td>
                            <td class="px-6 py-6 text-on-surface-variant"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($session['started_at'] ?? $session['start_date']))) ?></td>
                            <td class="px-6 py-6 text-on-surface-variant"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($session['ended_at'] ?? $session['end_date']))) ?></td>
                            <td class="px-8 py-6 text-right">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-primary/10 text-primary border border-primary/20">
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
        <a href="<?= BASE_URL ?>/sessions/dashboard" class="text-primary font-bold mt-4 inline-block">Voir le dashboard</a>
    </div>
    <?php endif; ?>
    </div>
</main>