

<header class="bg-zinc-950/60 backdrop-blur-xl docked full-width top-0 z-50 shadow-[0_4px_40px_0_rgba(233,195,73,0.08)] flex justify-between items-center px-8 py-4 w-full sticky">
    <div class="flex items-center gap-8">
        <div class="text-2xl font-black uppercase text-yellow-600 dark:text-yellow-500 font-['Epilogue'] tracking-tighter leading-tight">
            Aji L3bo Café
        </div>
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-zinc-400 font-medium hover:text-yellow-400 transition-colors duration-300 active:scale-95 transition-transform" href="/sessions/dashboard">Dashboard</a>
            <a class="text-yellow-500 border-b-2 border-yellow-500 pb-1 font-bold hover:text-yellow-400 transition-colors duration-300 active:scale-95 transition-transform" href="/reservations">Reservations</a>
            <a class="text-zinc-400 font-medium hover:text-yellow-400 transition-colors duration-300 active:scale-95 transition-transform" href="/games">Inventory</a>
        </nav>
    </div>
    <div class="flex items-center gap-4">
        <button class="text-zinc-400 hover:text-yellow-400 transition-colors duration-300 active:scale-95 transition-transform">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <button class="text-zinc-400 hover:text-yellow-400 transition-colors duration-300 active:scale-95 transition-transform">
            <span class="material-symbols-outlined">settings</span>
        </button>
    </div>
</header>

<main class="max-w-7xl mx-auto px-8 py-12">
    <div class="mb-12 relative overflow-hidden rounded-xl bg-surface-container-low p-10 border border-outline-variant/10">
        <div class="relative z-10">
            <h1 class="text-5xl font-extrabold tracking-tighter text-on-surface mb-2">Gestion des Réservations</h1>
            <p class="text-primary text-lg font-medium opacity-80 uppercase tracking-widest">Toutes les réservations</p>
        </div>
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute right-10 bottom-0 opacity-10 pointer-events-none">
            <span class="material-symbols-outlined !text-[160px]">calendar_today</span>
        </div>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-8 gap-4 bg-surface-container-lowest/50 p-6 rounded-xl border-b border-outline-variant/10">
        <div class="flex flex-wrap gap-4 items-center w-full md:w-auto">
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-outline uppercase tracking-wider px-1">Date</label>
                <div class="relative">
                    <input class="bg-surface-container-high border-none text-on-surface rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 transition-all w-full md:w-48 text-sm appearance-none" type="date" name="filter_date"/>
                </div>
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-outline uppercase tracking-wider px-1">Statut</label>
                <select class="bg-surface-container-high border-none text-on-surface rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 transition-all w-full md:w-56 text-sm" name="filter_status">
                    <option>Tous les statuts</option>
                    <option>En attente</option>
                    <option>Confirmée</option>
                    <option>Complétée</option>
                    <option>Annulée</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="/reservations/create" class="bg-primary hover:bg-primary-container text-on-primary font-bold px-6 py-3 rounded-lg flex items-center gap-2 transition-all active:scale-95 text-sm">
                <span class="material-symbols-outlined text-sm">add</span>
                Nouvelle Réservation
            </a>
        </div>
    </div>

    <div class="bg-surface-container-low rounded-xl overflow-hidden border border-outline-variant/10 shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-high/50 border-b border-outline-variant/20">
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-outline">Client</th>
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-outline">Table</th>
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-outline">Date &amp; Heure</th>
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-outline text-center">Durée</th>
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-outline text-center">Personnes</th>
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-outline">Statut</th>
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-outline text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    <?php foreach ($reservations as $reservation): ?>
                        <tr class="hover:bg-surface-container-highest/30 transition-colors group">
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                        <?= strtoupper(substr($reservation['user_name'], 0, 2)) ?>
                                    </div>
                                    <span class="font-bold text-on-surface"><?= htmlspecialchars($reservation['user_name']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-on-surface-variant font-medium">Table <?= htmlspecialchars($reservation['table']) ?></td>
                            <td class="px-6 py-6 text-on-surface-variant"><?= htmlspecialchars($reservation['date']) ?> <?= htmlspecialchars($reservation['time']) ?></td>
                            <td class="px-6 py-6 text-center text-on-surface-variant"><?= $reservation['duration'] ?>h</td>
                            <td class="px-6 py-6 text-center text-on-surface-variant"><?= $reservation['people_count'] ?></td>
                            <td class="px-6 py-6">
                                <?php if ($reservation['status'] === 'pending'): ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">En attente</span>
                                <?php elseif ($reservation['status'] === 'confirmed'): ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-blue-500/10 text-blue-400 border border-blue-500/20">Confirmée</span>
                                <?php elseif ($reservation['status'] === 'completed'): ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-zinc-500/10 text-zinc-400 border border-zinc-500/20">Complétée</span>
                                <?php elseif ($reservation['status'] === 'cancelled'): ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-red-500/10 text-red-500 border border-red-500/20">Annulée</span>
                                <?php endif; ?>
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
            <p class="text-xs text-outline font-medium">Affichage de <?= count($reservations) ?> réservations</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
        <div class="bg-surface-container-high p-6 rounded-xl border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined !text-6xl">pending_actions</span>
            </div>
            <p class="text-outline text-xs font-bold uppercase tracking-widest mb-1">En attente</p>
            <h3 class="text-3xl font-black text-on-surface"><?= $pendingCount ?? 0 ?></h3>
            <p class="text-emerald-400 text-[10px] font-bold mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined !text-xs">trending_up</span> +3 depuis hier
            </p>
        </div>
        <div class="bg-surface-container-high p-6 rounded-xl border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined !text-6xl">check_circle</span>
            </div>
            <p class="text-outline text-xs font-bold uppercase tracking-widest mb-1">Confirmées</p>
            <h3 class="text-3xl font-black text-on-surface"><?= $confirmedCount ?? 0 ?></h3>
            <p class="text-emerald-400 text-[10px] font-bold mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined !text-xs">trending_up</span> +8 cette semaine
            </p>
        </div>
        <div class="bg-surface-container-high p-6 rounded-xl border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined !text-6xl">table_bar</span>
            </div>
            <p class="text-outline text-xs font-bold uppercase tracking-widest mb-1">Taux d'occupation</p>
            <h3 class="text-3xl font-black text-on-surface"><?= $occupancyRate ?? 0 ?>%</h3>
            <div class="w-full bg-zinc-800 h-1 rounded-full mt-4 overflow-hidden">
                <div class="bg-primary h-full" style="width: <?= $occupancyRate ?? 0 ?>%"></div>
            </div>
        </div>
    </div>
</main>
