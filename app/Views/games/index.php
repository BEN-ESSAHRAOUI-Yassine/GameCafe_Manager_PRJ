

<header class="fixed top-0 w-full flex justify-between items-center px-8 py-4 bg-[#131313]/60 backdrop-blur-xl z-50">
    <div class="text-2xl font-bold tracking-tighter text-[#d4af37] font-headline uppercase">
        Aji L3bo Café
    </div>
    <nav class="hidden md:flex items-center gap-8">
        <a class="font-headline uppercase tracking-tight text-[#d4af37] border-b-2 border-[#d4af37] pb-1" href="/games">Jeux</a>
        <a class="font-headline uppercase tracking-tight text-gray-400 hover:text-[#d4af37] transition-colors" href="/reservations">Réservations</a>
        <a class="font-headline uppercase tracking-tight text-gray-400 hover:text-[#d4af37] transition-colors" href="/sessions/dashboard">Dashboard</a>
    </nav>
    <div class="flex items-center gap-4">
        <a href="/logout" class="font-headline uppercase tracking-tight text-gray-400 hover:text-[#f2ca50] transition-all duration-300 scale-95 active:opacity-80">
            Se déconnecter
        </a>
    </div>
</header>

<main class="pt-32 pb-24 px-4 md:px-12 max-w-7xl mx-auto">
    <section class="mb-12 flex flex-col lg:flex-row lg:items-end justify-between gap-8">
        <div class="space-y-4">
            <h1 class="text-5xl md:text-6xl font-headline font-bold tracking-tighter text-on-surface">
                Catalogue des Jeux
            </h1>
            <div class="flex flex-wrap gap-2">
                <button class="px-6 py-2 rounded-full bg-primary-container text-on-primary-container font-headline text-sm font-bold transition-all">Tous</button>
                <button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-headline text-sm hover:bg-surface-variant transition-all">Stratégie</button>
                <button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-headline text-sm hover:bg-surface-variant transition-all">Ambiance</button>
                <button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-headline text-sm hover:bg-surface-variant transition-all">Famille</button>
                <button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-headline text-sm hover:bg-surface-variant transition-all">Experts</button>
            </div>
        </div>
        <a href="/games/create" class="flex items-center gap-2 bg-[#2d5a27] hover:bg-[#387031] text-white px-8 py-4 rounded-xl font-headline font-bold transition-transform active:scale-95 self-start lg:self-end">
            <span class="material-symbols-outlined">add</span>
            Ajouter un jeu
        </a>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($games as $game): ?>
            <article class="group bg-surface-container-low rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:translate-y-[-4px]">
                <div class="h-64 relative overflow-hidden">
                    <?php if (!empty($game['image'])): ?>
                        <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="<?= htmlspecialchars($game['image']) ?>" alt="<?= htmlspecialchars($game['name']) ?>"/>
                    <?php endif; ?>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-teal-900/80 text-teal-200 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-widest"><?= htmlspecialchars($game['category']) ?></span>
                    </div>
                </div>
                <div class="p-8 flex-grow flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-headline font-bold text-on-surface"><?= htmlspecialchars($game['name']) ?></h3>
                        <?php if ($game['status'] === 'available'): ?>
                            <span class="text-green-500 font-bold text-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                Disponible ✅
                            </span>
                        <?php else: ?>
                            <span class="text-error font-bold text-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">error</span>
                                En cours 🔴
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="flex gap-6 mb-8 text-on-surface-variant/70 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">groups</span>
                            <?= $game['players_min'] ?>-<?= $game['players_max'] ?> joueurs
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">schedule</span>
                            <?= $game['duration'] ?> min
                        </div>
                    </div>
                    <a class="mt-auto flex items-center gap-2 text-[#d4af37] font-headline font-bold hover:gap-4 transition-all" href="/games/<?= $game['id'] ?>">
                        Voir les détails <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</main>
