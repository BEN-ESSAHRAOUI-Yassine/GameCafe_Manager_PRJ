<?php require __DIR__ . '/../layouts/header.php'; ?>

<nav class="fixed top-0 w-full z-50 bg-neutral-950/60 backdrop-blur-xl shadow-[0_40px_0_0_rgba(233,195,73,0.08)]">
    <div class="flex justify-between items-center px-8 py-4 max-w-7xl mx-auto">
        <div class="text-2xl font-bold tracking-tighter text-yellow-500 font-headline">Aji L3bo</div>
        <div class="hidden md:flex items-center gap-8 font-headline tracking-tight">
            <a class="text-neutral-400 hover:text-neutral-200 transition-colors" href="/games">Jeux</a>
            <a class="text-neutral-400 hover:text-neutral-200 transition-colors" href="/reservations">Réservations</a>
            <a class="text-yellow-500 border-b-2 border-yellow-500 pb-1" href="/sessions/dashboard">Dashboard</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="/logout" class="p-2 rounded-full hover:bg-neutral-800/50 transition-all active:scale-95 duration-200 text-neutral-400">
                <span class="material-symbols-outlined">logout</span>
            </a>
        </div>
    </div>
</nav>

<main class="flex-grow pt-32 pb-20 px-6 flex flex-col items-center justify-center relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] -z-10 translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-surface-tint/5 rounded-full blur-[100px] -z-10 -translate-x-1/2 translate-y-1/2"></div>

    <div class="w-full max-w-2xl mb-10 text-center md:text-left">
        <h1 class="text-4xl md:text-5xl font-extrabold font-headline text-on-surface tracking-tight mb-2">
            Ajouter un nouveau jeu
        </h1>
        <p class="text-on-surface-variant font-body text-lg">
            Remplissez les informations du jeu
        </p>
    </div>

    <div class="w-full max-w-2xl bg-surface-container-low rounded-xl p-8 md:p-12 relative">
        <div class="absolute inset-0 border border-outline-variant/15 rounded-xl pointer-events-none"></div>
        
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/games" class="space-y-8">
            <div class="space-y-2">
                <label class="block text-sm font-semibold tracking-widest uppercase text-on-surface-variant font-label" for="name">
                    Nom du jeu
                </label>
                <input class="w-full bg-surface-container-high border-0 focus:ring-2 focus:ring-primary rounded-lg px-4 py-3.5 text-on-surface placeholder:text-neutral-600 transition-all duration-200 font-body outline-none" id="name" name="name" placeholder="Ex: Catan" type="text"/>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold tracking-widest uppercase text-on-surface-variant font-label" for="category">
                    Catégorie
                </label>
                <div class="relative">
                    <select class="w-full bg-surface-container-high border-0 focus:ring-2 focus:ring-primary rounded-lg px-4 py-3.5 text-on-surface appearance-none transition-all duration-200 font-body outline-none cursor-pointer" id="category" name="category">
                        <option value="strategie">Stratégie</option>
                        <option value="ambiance">Ambiance</option>
                        <option value="famille">Famille</option>
                        <option value="experts">Experts</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold tracking-widest uppercase text-on-surface-variant font-label" for="description">
                    Description
                </label>
                <textarea class="w-full bg-surface-container-high border-0 focus:ring-2 focus:ring-primary rounded-lg px-4 py-3.5 text-on-surface placeholder:text-neutral-600 transition-all duration-200 font-body outline-none resize-none" id="description" name="description" placeholder="Décrivez le jeu en quelques phrases..." rows="4"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold tracking-widest uppercase text-on-surface-variant font-label" for="difficulty">
                        Difficulté (1 à 5)
                    </label>
                    <input class="w-full bg-surface-container-high border-0 focus:ring-2 focus:ring-primary rounded-lg px-4 py-3.5 text-on-surface placeholder:text-neutral-600 transition-all duration-200 font-body outline-none" id="difficulty" name="difficulty" max="5" min="1" placeholder="3" type="number"/>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold tracking-widest uppercase text-on-surface-variant font-label" for="duration">
                        Durée estimée (minutes)
                    </label>
                    <input class="w-full bg-surface-container-high border-0 focus:ring-2 focus:ring-primary rounded-lg px-4 py-3.5 text-on-surface placeholder:text-neutral-600 transition-all duration-200 font-body outline-none" id="duration" name="duration" placeholder="60" type="number"/>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold tracking-widest uppercase text-on-surface-variant font-label" for="players_min">
                        Joueurs min
                    </label>
                    <input class="w-full bg-surface-container-high border-0 focus:ring-2 focus:ring-primary rounded-lg px-4 py-3.5 text-on-surface placeholder:text-neutral-600 transition-all duration-200 font-body outline-none" id="players_min" name="players_min" placeholder="2" type="number"/>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold tracking-widest uppercase text-on-surface-variant font-label" for="players_max">
                        Joueurs max
                    </label>
                    <input class="w-full bg-surface-container-high border-0 focus:ring-2 focus:ring-primary rounded-lg px-4 py-3.5 text-on-surface placeholder:text-neutral-600 transition-all duration-200 font-body outline-none" id="players_max" name="players_max" placeholder="4" type="number"/>
                </div>
            </div>

            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>

            <div class="pt-6 flex flex-col md:flex-row items-center gap-4">
                <button class="w-full md:w-auto px-10 py-4 bg-primary text-on-primary font-bold rounded-lg hover:bg-primary-container transition-all active:scale-95 duration-200 shadow-xl shadow-primary/10" type="submit">
                    Ajouter le jeu
                </button>
                <a href="/games" class="w-full md:w-auto px-10 py-4 bg-transparent text-neutral-400 font-bold rounded-lg border border-outline-variant/30 hover:border-neutral-200 hover:text-neutral-200 transition-all active:scale-95 duration-200 text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
