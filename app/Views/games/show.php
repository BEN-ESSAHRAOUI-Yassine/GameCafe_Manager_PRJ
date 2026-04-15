<main class="max-w-4xl px-6 py-12 mb-24 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>

    <a class="inline-flex items-center gap-2 text-primary hover:text-primary-fixed-dim transition-colors mb-12 group relative z-10" href="<?= BASE_URL ?>/games">
        <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
        <span class="font-semibold text-sm tracking-wide uppercase">Retour au catalogue</span>
    </a>

    <div class="flex flex-col md:flex-row gap-12 items-start relative z-10">
        <div class="w-full md:w-5/12 aspect-[4/5] rounded-xl overflow-hidden shadow-2xl relative group border border-outline-variant/15">
            <div class="absolute inset-0 bg-gradient-to-t from-surface via-transparent to-transparent opacity-60 z-10"></div>
            <?php if (!empty($game['image'])): ?>
                <img alt="<?= htmlspecialchars($game['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= htmlspecialchars($game['image']) ?>"/>
            <?php endif; ?>
            <div class="absolute bottom-4 left-4 z-20 flex gap-2">
                <span class="px-3 py-1 bg-teal-500/20 text-teal-300 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-widest border border-teal-500/30"><?= htmlspecialchars($game['category']) ?></span>
                <?php if ($game['status'] === 'available'): ?>
                    <span class="px-3 py-1 bg-green-500/20 text-green-300 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-widest border border-green-500/30">Disponible</span>
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
                <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/15">
                    <span class="text-on-surface-variant text-[10px] uppercase font-bold tracking-widest block mb-3">Difficulté</span>
                    <div class="flex gap-1 text-primary">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="material-symbols-outlined" <?= $i <= $game['difficulty'] ? 'style="font-variation-settings: \'FILL\' 1;"' : '' ?>>star</span>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/15">
                    <span class="text-on-surface-variant text-[10px] uppercase font-bold tracking-widest block mb-3">Joueurs</span>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">group</span>
                        <span class="font-headline font-bold text-lg text-on-surface"><?= $game['min_players'] ?> – <?= $game['max_players'] ?></span>
                    </div>
                </div>
                <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/15">
                    <span class="text-on-surface-variant text-[10px] uppercase font-bold tracking-widest block mb-3">Durée</span>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">schedule</span>
                        <span class="font-headline font-bold text-lg text-on-surface"><?= $game['duration_minutes'] ?> min</span>
                    </div>
                </div>
                <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/15">
                    <span class="text-on-surface-variant text-[10px] uppercase font-bold tracking-widest block mb-3">Catégorie</span>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">category</span>
                        <span class="font-headline font-bold text-lg text-on-surface"><?= htmlspecialchars($game['category']) ?></span>
                    </div>
                </div>
            </div>

            <?php if (\Core\Controller::isAdmin()): ?>
            <div class="mt-8 pt-8 border-t border-outline-variant/15 flex flex-col sm:flex-row items-center gap-4">
                <a href="<?= BASE_URL ?>/games/<?= $game['id'] ?>/edit" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-4 border-2 border-primary-container text-primary-container rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-primary-container hover:text-on-primary transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Modifier
                </a>
                <form method="POST" action="<?= BASE_URL ?>/games/<?= $game['id'] ?>/delete" class="w-full sm:w-auto">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-8 py-4 border-2 border-error text-error rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-error hover:text-on-error transition-all active:scale-95">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Supprimer
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>