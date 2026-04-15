<main class="flex-grow pt-32 pb-20 px-6 flex flex-col items-center justify-center relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>

    <div class="w-full max-w-2xl mb-10 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 rounded-full bg-primary/10 border border-primary/20">
            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            <span class="text-xs tracking-widest uppercase text-primary">Jeux</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold font-headline text-on-surface tracking-tighter mb-2">
            Ajouter un nouveau jeu
        </h1>
        <p class="text-on-surface-variant font-body text-lg">
            Remplissez les informations du jeu
        </p>
    </div>

    <div class="w-full max-w-2xl bg-surface-container-low rounded-xl p-8 md:p-12 relative z-10 border border-outline-variant/15">
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/games" class="space-y-6">
            <div class="space-y-2">
                <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="name">
                    Nom du jeu
                </label>
                <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" id="name" name="name" placeholder="Ex: Catan" type="text"/>
            </div>

            <div class="space-y-2">
                <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="category">
                    Catégorie
                </label>
                <div class="relative">
                    <select class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus appearance-none cursor-pointer" id="category" name="category">
                        <option value="Stratégie">Stratégie</option>
                        <option value="Ambiance">Ambiance</option>
                        <option value="Famille">Famille</option>
                        <option value="Experts">Experts</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="description">
                    Description
                </label>
                <textarea class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus resize-none" id="description" name="description" placeholder="Décrivez le jeu en quelques phrases..." rows="4"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="difficulty">
                        Difficulté (1 à 5)
                    </label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" id="difficulty" name="difficulty" max="5" min="1" placeholder="3" type="number"/>
                </div>
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="duration_minutes">
                        Durée estimée (minutes)
                    </label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" id="duration_minutes" name="duration_minutes" placeholder="60" type="number"/>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="min_players">
                        Joueurs min
                    </label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" id="min_players" name="min_players" placeholder="2" type="number"/>
                </div>
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="max_players">
                        Joueurs max
                    </label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" id="max_players" name="max_players" placeholder="4" type="number"/>
                </div>
            </div>

            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>

            <div class="pt-4 flex flex-col md:flex-row items-center gap-4">
                <button class="w-full md:w-auto px-10 py-4 btn-primary font-headline font-bold rounded-lg transition-all" type="submit">
                    Ajouter le jeu
                </button>
                <a href="/games" class="w-full md:w-auto px-10 py-4 bg-transparent text-on-surface-variant font-bold rounded-lg border border-outline-variant/30 hover:border-primary hover:text-primary transition-all text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</main>