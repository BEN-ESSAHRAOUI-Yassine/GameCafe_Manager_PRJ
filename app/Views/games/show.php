

<header class="bg-zinc-900/60 backdrop-blur-xl flex justify-between items-center px-6 py-4 w-full sticky top-0 z-50 shadow-[0_40px_40px_rgba(233,195,73,0.08)]">
    <div class="flex items-center gap-8">
        <h1 class="text-2xl font-bold tracking-tighter text-yellow-500">Aji L3bo</h1>
        <nav class="hidden md:flex gap-6">
            <a class="text-yellow-500 font-bold font-['Epilogue'] tracking-tighter hover:text-yellow-400 transition-colors" href="#">Discover</a>
            <a class="text-zinc-400 font-['Epilogue'] tracking-tighter hover:text-yellow-400 transition-colors" href="/games">Library</a>
            <a class="text-zinc-400 font-['Epilogue'] tracking-tighter hover:text-yellow-400 transition-colors" href="#">Bookings</a>
        </nav>
    </div>
    <div class="flex items-center gap-4">
        <button class="material-symbols-outlined text-zinc-400 hover:text-yellow-400 transition-colors">notifications</button>
        <button class="bg-primary text-on-primary px-5 py-2 rounded-lg font-bold text-sm tracking-tight active:scale-95 duration-200">Book Table</button>
    </div>
</header>

<main class="max-w-4xl mx-auto px-6 py-12 mb-24">
    <a class="inline-flex items-center gap-2 text-primary hover:text-primary-fixed-dim transition-colors mb-12 group" href="/games">
        <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
        <span class="font-semibold text-sm tracking-wide uppercase">Retour au catalogue</span>
    </a>

    <div class="flex flex-col md:flex-row gap-12 items-start">
        <div class="w-full md:w-5/12 aspect-[4/5] rounded-xl overflow-hidden shadow-2xl relative group">
            <div class="absolute inset-0 bg-gradient-to-t from-surface via-transparent to-transparent opacity-60 z-10"></div>
            <?php if (!empty($game['image'])): ?>
                <img alt="<?= htmlspecialchars($game['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= htmlspecialchars($game['image']) ?>"/>
            <?php endif; ?>
            <div class="absolute bottom-4 left-4 z-20 flex gap-2">
                <span class="px-3 py-1 bg-teal-500/20 text-teal-300 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-widest border border-teal-500/30"><?= htmlspecialchars($game['category']) ?></span>
                <?php if ($game['status'] === 'available'): ?>
                    <span class="px-3 py-1 bg-green-500/20 text-green-300 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-widest border border-green-500/30">✅ Disponible</span>
                <?php else: ?>
                    <span class="px-3 py-1 bg-red-500/20 text-red-300 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-widest border border-red-500/30">En cours</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="w-full md:w-7/12 flex flex-col gap-8">
            <div class="space-y-4">
                <h2 class="text-6xl font-black tracking-tighter text-on-surface"><?= htmlspecialchars($game['name']) ?></h2>
                <p class="text-on-surface-variant text-lg leading-relaxed font-body">
                    <?= htmlspecialchars($game['description'] ?? '') ?>
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/10">
                    <span class="text-zinc-500 text-[10px] uppercase font-bold tracking-[0.2em] block mb-3">Difficulté</span>
                    <div class="flex gap-1 text-primary">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="material-symbols-outlined" <?= $i <= $game['difficulty'] ? 'style="font-variation-settings: \'FILL\' 1;"' : '' ?>>star</span>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/10">
                    <span class="text-zinc-500 text-[10px] uppercase font-bold tracking-[0.2em] block mb-3">Joueurs</span>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">group</span>
                        <span class="font-headline font-bold text-lg text-on-surface"><?= $game['players_min'] ?> – <?= $game['players_max'] ?></span>
                    </div>
                </div>
                <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/10">
                    <span class="text-zinc-500 text-[10px] uppercase font-bold tracking-[0.2em] block mb-3">Durée</span>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">schedule</span>
                        <span class="font-headline font-bold text-lg text-on-surface"><?= $game['duration'] ?> min</span>
                    </div>
                </div>
                <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/10">
                    <span class="text-zinc-500 text-[10px] uppercase font-bold tracking-[0.2em] block mb-3">Catégorie</span>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">category</span>
                        <span class="font-headline font-bold text-lg text-on-surface"><?= htmlspecialchars($game['category']) ?></span>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-outline-variant/15 flex flex-col sm:flex-row items-center gap-4">
                <a href="/games/<?= $game['id'] ?>/edit" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-4 border-2 border-primary-container text-primary-container rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-primary-container hover:text-on-primary transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Modifier
                </a>
                <form method="POST" action="/games/<?= $game['id'] ?>/delete" class="w-full sm:w-auto">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-8 py-4 border-2 border-error text-error rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-error hover:text-on-error transition-all active:scale-95">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-3 bg-zinc-900/60 backdrop-blur-xl rounded-t-3xl shadow-2xl">
    <a class="flex flex-col items-center justify-center text-zinc-500 px-4 py-2 hover:bg-zinc-800/50 transition-all active:scale-90 duration-150" href="/games">
        <span class="material-symbols-outlined">explore</span>
        <span class="font-['Manrope'] text-[11px] font-medium uppercase tracking-widest mt-1">Discover</span>
    </a>
    <a class="flex flex-col items-center justify-center bg-yellow-500/10 text-yellow-500 rounded-xl px-4 py-2 hover:bg-zinc-800/50 transition-all active:scale-90 duration-150" href="/games">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">casino</span>
        <span class="font-['Manrope'] text-[11px] font-medium uppercase tracking-widest mt-1">Library</span>
    </a>
    <a class="flex flex-col items-center justify-center text-zinc-500 px-4 py-2 hover:bg-zinc-800/50 transition-all active:scale-90 duration-150" href="/reservations">
        <span class="material-symbols-outlined">calendar_today</span>
        <span class="font-['Manrope'] text-[11px] font-medium uppercase tracking-widest mt-1">Bookings</span>
    </a>
    <a class="flex flex-col items-center justify-center text-zinc-500 px-4 py-2 hover:bg-zinc-800/50 transition-all active:scale-90 duration-150" href="/profile">
        <span class="material-symbols-outlined">person</span>
        <span class="font-['Manrope'] text-[11px] font-medium uppercase tracking-widest mt-1">Profile</span>
    </a>
</nav>