<main class="pt-32 pb-24 px-4 md:px-12 max-w-7xl relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>
    
    <div class="relative z-10">
        <section class="mb-12 flex flex-col lg:flex-row lg:items-end justify-between gap-8">
            <div class="space-y-4">
                <h1 class="text-5xl md:text-6xl font-headline font-bold tracking-tighter text-on-surface">
                    Catalogue des Jeux
                </h1>
                <p class="text-on-surface-variant font-body opacity-80">Découvrez notre collection</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="<?= BASE_URL ?>/games" class="px-6 py-2 rounded-full <?= $category === null ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-highest text-on-surface-variant hover:bg-surface-variant' ?> font-headline text-sm font-bold transition-all">Tous</a>
                <a href="<?= BASE_URL ?>/games?category=Stratégie" class="px-6 py-2 rounded-full <?= $category === 'Stratégie' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-highest text-on-surface-variant hover:bg-surface-variant' ?> font-headline text-sm font-bold transition-all">Stratégie</a>
                <a href="<?= BASE_URL ?>/games?category=Ambiance" class="px-6 py-2 rounded-full <?= $category === 'Ambiance' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-highest text-on-surface-variant hover:bg-surface-variant' ?> font-headline text-sm font-bold transition-all">Ambiance</a>
                <a href="<?= BASE_URL ?>/games?category=Famille" class="px-6 py-2 rounded-full <?= $category === 'Famille' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-highest text-on-surface-variant hover:bg-surface-variant' ?> font-headline text-sm font-bold transition-all">Famille</a>
                <a href="<?= BASE_URL ?>/games?category=Experts" class="px-6 py-2 rounded-full <?= $category === 'Experts' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-highest text-on-surface-variant hover:bg-surface-variant' ?> font-headline text-sm font-bold transition-all">Experts</a>
            </div>
        </section>
<?php if (\Core\Controller::isAdmin()): ?>
            <a href="<?= BASE_URL ?>/games/create" class="flex items-center gap-2 btn-primary px-8 py-4 rounded-xl font-headline font-bold transition-transform active:scale-95 self-start lg:self-end">
                <span class="material-symbols-outlined">add</span>
                Ajouter un jeu
            </a>
            <?php endif; ?>
    </section>

    <div class="grid grid-cols-2 gap-6">
        <?php foreach ($games as $game): ?>
            <article class="group bg-surface-container-low rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:translate-y-[-4px] border border-outline-variant/15">
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
                                Disponible
                            </span>
                        <?php else: ?>
                            <span class="text-error font-bold text-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">error</span>
                                En cours
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="flex gap-6 mb-8 text-on-surface-variant text-sm">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">groups</span>
                            <?= $game['min_players'] ?>-<?= $game['max_players'] ?> joueurs
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">schedule</span>
                            <?= $game['duration_minutes'] ?> min
                        </div>
                    </div>
                    <a class="mt-auto flex items-center gap-2 text-primary font-headline font-bold hover:gap-4 transition-all" href="<?= BASE_URL ?>/games/<?= $game['id'] ?>">
                        Voir les détails <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</main>