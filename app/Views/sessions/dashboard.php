<?php require __DIR__ . '/../layouts/header.php'; ?>

<header class="fixed top-0 w-full z-50 bg-[#131313]/60 backdrop-blur-xl shadow-[0_40px_40px_-15px_rgba(233,195,73,0.08)] flex justify-between items-center px-8 h-16">
    <div class="text-xl font-bold text-[#d4af37] tracking-tighter font-headline">
        Aji L3bo Admin
    </div>
    <nav class="hidden md:flex items-center gap-8">
        <a class="text-[#d4af37] border-b-2 border-[#d4af37] pb-1 font-bold font-headline tracking-tight transition-all duration-300" href="/sessions/dashboard">Dashboard</a>
        <a class="text-zinc-400 font-medium hover:text-zinc-200 font-headline tracking-tight hover:bg-white/5 px-3 py-1 rounded transition-all duration-300" href="/reservations">Reservations</a>
        <a class="text-zinc-400 font-medium hover:text-zinc-200 font-headline tracking-tight hover:bg-white/5 px-3 py-1 rounded transition-all duration-300" href="/games">Inventory</a>
    </nav>
    <div class="flex items-center gap-4">
        <button class="text-on-surface-variant hover:bg-white/5 p-2 rounded-full transition-all active:scale-95">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <button class="text-on-surface-variant hover:bg-white/5 p-2 rounded-full transition-all active:scale-95">
            <span class="material-symbols-outlined">settings</span>
        </button>
    </div>
</header>

<main class="pt-28 pb-20 px-6 md:px-12 max-w-7xl mx-auto min-h-screen flex flex-col">
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-2">
            <div class="h-3 w-3 bg-green-500 rounded-full animate-pulse-soft shadow-[0_0_10px_rgba(34,197,94,0.6)]"></div>
            <h1 class="text-4xl font-extrabold font-headline tracking-tight text-on-surface">Dashboard — Sessions Actives</h1>
        </div>
        <p class="text-on-surface-variant font-medium tracking-wide uppercase text-sm opacity-80"><?= $activeCount ?? 0 ?> tables · <?= $occupiedCount ?? 0 ?> occupées</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <?php foreach ($tables as $table): ?>
            <?php if ($table['status'] === 'occupied'): ?>
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
                            <h2 class="text-3xl font-bold font-headline text-on-surface">Table <?= htmlspecialchars($table['number']) ?></h2>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-3xl">casino</span>
                        </div>
                    </div>
                    <div class="space-y-6 mb-10">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <p class="text-xs text-on-surface-variant uppercase font-bold tracking-tighter">Jeu en cours</p>
                                <p class="text-lg font-semibold flex items-center gap-2">🎲 <?= htmlspecialchars($table['game_name']) ?></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs text-on-surface-variant uppercase font-bold tracking-tighter">Client</p>
                                <p class="text-lg font-semibold flex items-center gap-2">👤 <?= htmlspecialchars($table['user_name']) ?></p>
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
                                    <p class="font-medium text-on-surface"><?= htmlspecialchars($table['start_time']) ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-on-surface-variant uppercase font-bold tracking-tighter">Prévu</p>
                                    <p class="font-medium text-on-surface"><?= $table['duration'] ?>h</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-on-surface-variant uppercase font-bold tracking-tighter">Écoulé</p>
                                    <p class="font-bold text-primary"><?= $table['elapsed'] ?? 0 ?> min</p>
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
                            <h2 class="text-5xl font-black font-headline text-on-surface/40 group-hover:text-on-surface transition-colors">Table <?= htmlspecialchars($table['number']) ?></h2>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-surface-container-highest flex items-center justify-center text-on-surface-variant group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-3xl">table_restaurant</span>
                        </div>
                    </div>
                    <div class="mb-10 flex items-center gap-2 text-on-surface-variant">
                        <span class="material-sy
