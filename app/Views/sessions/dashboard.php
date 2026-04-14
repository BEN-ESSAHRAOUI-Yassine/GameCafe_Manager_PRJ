<main class="pt-28 pb-20 px-6 md:px-12 max-w-7xl mx-auto min-h-screen flex flex-col">
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-2">
            <div class="h-3 w-3 bg-green-500 rounded-full animate-pulse-soft shadow-[0_0_10px_rgba(34,197,94,0.6)]"></div>
            <h1 class="text-4xl font-extrabold font-headline tracking-tight text-on-surface">Dashboard — Sessions Actives</h1>
        </div>
        <p class="text-on-surface-variant font-medium tracking-wide uppercase text-sm opacity-80"><?= count(array_filter($tables ?? [], fn($t) => ($t['status'] ?? $t['session_id']))) ?? 0 ?> tables · <?= count(array_filter($tables ?? [], fn($t) => ($t['status'] ?? '') === 'occupied')) ?? 0 ?> occupées</p>
    </div>

    <?php if (!empty($tables)): ?>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <?php foreach ($tables as $table): ?>
            <?php if (!empty($table['session_id'])): ?>
                <div class="group relative bg-surface-container-low p-8 rounded-xl border border-white/5 transition-all duration-500 hover:bg-surface-container hover:shadow-[0_20px_50px_-20px_rgba(0,0,0,0.5)]">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <?php if (!empty($table['overtime'])): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-500 text-on-error text-xs font-black uppercase tracking-widest mb-4">
                                    🔴 Occupée ⚠️
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-500/10 text-red-400 text-xs font-bold uppercase tracking-widest mb-4">
                                    🔴 Occupée
                                </span>
                            <?php endif; ?>
                            <h2 class="text-3xl font-bold font-headline text-on-surface">Table <?= htmlspecialchars($table['name'] ?? $table['number'] ?? $table['id']) ?></h2>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-3xl">casino</span>
                        </div>
                    </div>
                    <div class="space-y-6 mb-10">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <p class="text-xs text-on-surface-variant uppercase font-bold tracking-tighter">Jeu en cours</p>
                                <p class="text-lg font-semibold flex items-center gap-2">🎲 <?= htmlspecialchars($table['game_name'] ?? 'Jeu') ?></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs text-on-surface-variant uppercase font-bold tracking-tighter">Client</p>
                                <p class="text-lg font-semibold flex items-center gap-2">👤 <?= htmlspecialchars($table['client_name'] ?? $table['user_name'] ?? 'Client') ?></p>
                            </div>
                        </div>
                        <?php if (!empty($table['overtime'])): ?>
                            <div class="p-6 rounded-lg bg-error-container/20 border border-error-container/30 flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-error uppercase font-bold tracking-tighter">Temps dépassé</p>
                                    <p class="text-2xl font-black text-error"><?= $table['overtime'] ?> min</p>
                                </div>
                                <span class="material-symbols-outlined text-error text-4xl animate-pulse">warning</span>
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-3 gap-4 py-4 border-y border-white/5">
                                <div>
                                    <p class="text-xs text-on-surface-variant uppercase font-bold tracking-tighter">Début</p>
                                    <p class="font-medium text-on-surface"><?= htmlspecialchars(date('H:i', strtotime($table['started_at'] ?? $table['start_time'] ?? 'now'))) ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-on-surface-variant uppercase font-bold tracking-tighter">Prévu</p>
                                    <p class="font-medium text-on-surface"><?= $table['duration_hours'] ?? $table['duration'] ?? 1 ?>h</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-on-surface-variant uppercase font-bold tracking-tighter">Écoulé</p>
                                    <p class="font-bold text-primary"><?= $table['elapsed_minutes'] ?? $table['elapsed'] ?? 0 ?> min</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <form method="POST" action="/sessions/<?= $table['session_id'] ?>/end">
                        <button class="w-full py-4 rounded-lg bg-red-500/10 text-red-500 font-bold uppercase tracking-widest text-sm border border-red-500/20 hover:bg-red-500 hover:text-white transition-all active:scale-95">
                            Terminer la session
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="group relative bg-surface-container-low p-8 rounded-xl border border-dashed border-white/10 transition-all duration-500 hover:bg-surface-container hover:border-primary/30">
                    <div class="flex justify-between items-start mb-12">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold uppercase tracking-widest mb-4">
                                ✅ Libre
                            </span>
                            <h2 class="text-5xl font-black font-headline text-on-surface/40 group-hover:text-on-surface transition-colors">Table <?= htmlspecialchars($table['name'] ?? $table['number'] ?? $table['id']) ?></h2>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-surface-container-highest flex items-center justify-center text-on-surface-variant group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-3xl">table_restaurant</span>
                        </div>
                    </div>
                    <div class="mb-10 flex items-center gap-2 text-on-surface-variant/40">
                        <span class="material-symbols-outlined text-4xl opacity-50">table_restaurant</span>
                        <span class="text-sm font-medium">Table disponible — Prête pour une session</span>
                    </div>
                    <a href="/sessions/create" class="block w-full py-4 rounded-lg bg-primary/10 text-primary font-bold uppercase tracking-widest text-sm border border-primary/20 hover:bg-primary hover:text-white transition-all active:scale-95 text-center">
                        Démarrer une session
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-20">
        <span class="material-symbols-outlined text-6xl text-on-surface-variant mb-4">table_restaurant</span>
        <p class="text-on-surface-variant text-lg">Aucune table disponible.</p>
    </div>
    <?php endif; ?>
</main>