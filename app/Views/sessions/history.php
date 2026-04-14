

<nav class="fixed top-0 w-full z-50 bg-[#131313]/60 backdrop-blur-xl bg-[#1c1b1b] border-none shadow-[0_40px_40px_rgba(233,195,73,0.08)]">
    <div class="flex justify-between items-center px-8 h-20 w-full max-w-[1920px] mx-auto">
        <div class="text-2xl font-bold tracking-tighter text-[#d4af37] font-['Epilogue'] tracking-tight">
            Aji L3bo Café
        </div>
        <div class="hidden md:flex items-center space-x-8">
            <a class="text-zinc-500 font-medium hover:text-zinc-200 transition-colors" href="/sessions/dashboard">Dashboard</a>
            <a class="text-[#f2ca50] border-b-2 border-[#f2ca50] pb-1 font-bold" href="/reservations">Reservations</a>
            <a class="text-zinc-500 font-medium hover:text-zinc-200 transition-colors" href="/games">Inventory</a>
        </div>
        <div class="flex items-center space-x-4">
            <button class="material-symbols-outlined text-zinc-500 hover:bg-white/5 p-2 rounded-full transition-all duration-300 active:scale-95 duration-200">notifications</button>
            <button class="material-symbols-outlined text-zinc-500 hover:bg-white/5 p-2 rounded-full transition-all duration-300 active:scale-95 duration-200">settings</button>
        </div>
    </div>
</nav>

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
                <span class="text-3xl font-headline font-bold"><?= number_format($totalSessions ?? 0) ?> Sessions</span>
            </div>
        </div>
    </header>

    <section class="mb-10 bg-surface-container-low p-1 rounded-2xl">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-4">
            <div class="flex flex-col space-y-2">
                <label class="text-xs font-bold text-outline uppercase tracking-wider pl-1">Du</label>
                <input class="bg-surface-container-high border-none rounded-lg text-on-surface focus:ring-2 focus:ring-primary py-3 px-4 transition-all" type="date" name="date_from"/>
            </div>
            <div class="flex flex-col space-y-2">
                <label class="text-xs font-bold text-outline uppercase tracking-wider pl-1">Au</label>
                <input class="bg-surface-container-high border-none rounded-lg text-on-surface focus:ring-2 focus:ring-primary py-3 px-4 transition-all" type="date" name="date_to"/>
            </div>
            <div class="flex flex-col space-y-2">
                <label class="text-xs font-bold text-outline uppercase tracking-wider pl-1">Jeu</label>
                <select class="bg-surface-container-high border-none rounded-lg text-on-surface focus:ring-2 focus:ring-primary py-3 px-4 transition-all appearance-none" name="game_id">
                    <option>Tous les jeux</option>
                    <?php foreach ($games as $game): ?>
                        <option value="<?= $game['id'] ?>"><?= htmlspecialchars($game['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex flex-col space-y-2">
                <label class="text-xs font-bold text-outline uppercase tracking-wider pl-1">Table</label>
                <select class="bg-surface-container-high border-none rounded-lg text-on-surface focus:ring-2 focus:ring-primary py-3 px-4 transition-all appearance-none" name="table_id">
                    <option>Toutes les tables</option>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>">Table <?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
    </section>

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
                        <tr class="row-hover transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                        <?= strtoupper(substr($session['user_name'], 0, 2)) ?>
                                    </div>
                                    <span class="font-bold text-on-surface"><?= htmlspecialchars($session['user_name']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center space-x-2">
                                    <span class="material-symbols-outlined text-outline">casino</span>
                                    <span class="text-on-surface-variant font-medium"><?= htmlspecialchars($session['game_name']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="bg-surface-container-highest px-3 py-1 rounded-md text-sm border border-white/5">Table <?= $session['table'] ?></span>
                            </td>
                            <td class="px-6 py-6 text-on-surface-variant font-mono"><?= htmlspecialchars($session['start_date']) ?> <?= htmlspecialchars($session['start_time']) ?></td>
                            <td class="px-6 py-6 text-on-surface-variant font-mono"><?= htmlspecialchars($session['end_date']) ?> <?= htmlspecialchars($session['end_time']) ?></td>
                            <td class="px-8 py-6 text-right">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-[#d4af37]/10 text-[#d4af37] border border-[#d4af37]/20">
                                    <span class="material-symbols-outlined text-sm mr-1.5">history_toggle_off</span>
                                    <?= $session['duration_hours'] ?? $session['duration'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-surface-container-high/50 flex items-center justify-between border-t border-white/5">
            <span class="text-sm text-outline">Affichage de <?= count($sessions) ?? 0 ?> sessions</span>
            <div class="flex space-x-2">
                <button class="p-2 rounded-lg bg-surface-container-highest text-on-surface hover:bg-primary/20 transition-all">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button class="px-4 py-2 rounded-lg bg-primary text-on-primary font-bold transition-all">1</button>
                <button class="px-4 py-2 rounded-lg bg-surface-container-highest text-on-surface hover:bg-primary/20 transition-all">2</button>
                <button class="px-4 py-2 rounded-lg bg-surface-container-highest text-on-surface hover:bg-primary/20 transition-all">3</button>
                <button class="p-2 rounded-lg bg-surface-container-highest text-on-surface hover:bg-primary/20 transition-all">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>
    </div>

    <div class="fixed bottom-10 right-10 pointer-events-none opacity-20 hidden lg:block">
        <span class="material-symbols-outlined text-[200px] text-primary select-none">playing_cards</span>
    </div>
</main>
