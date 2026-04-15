<main class="flex-grow flex items-center justify-center pt-24 pb-12 px-4 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>

    <div class="w-full max-w-2xl bg-surface-container-low p-8 md:p-12 rounded-xl border border-outline-variant/15 relative z-10">
        <div class="mb-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 rounded-full bg-primary/10 border border-primary/20">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-xs tracking-widest uppercase text-primary">Jeux</span>
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-on-surface mb-2">Modifier le jeu</h1>
            <p class="text-on-surface-variant font-medium tracking-wide">Mettre à jour les informations</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?= BASE_URL ?>/games/<?= $game['id'] ?>/update" class="space-y-6">
            <div class="space-y-2">
                <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="name">Nom du jeu</label>
                <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" name="name" type="text" value="<?= htmlspecialchars($game['name'] ?? '') ?>"/>
            </div>
            
            <div class="space-y-2">
                <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="category">Catégorie</label>
                <div class="relative">
                    <select class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus appearance-none cursor-pointer" name="category">
                        <option value="Stratégie" <?= ($game['category'] ?? '') === 'Stratégie' ? 'selected' : '' ?>>Stratégie</option>
                        <option value="Famille" <?= ($game['category'] ?? '') === 'Famille' ? 'selected' : '' ?>>Famille</option>
                        <option value="Ambiance" <?= ($game['category'] ?? '') === 'Ambiance' ? 'selected' : '' ?>>Ambiance</option>
                        <option value="Experts" <?= ($game['category'] ?? '') === 'Experts' ? 'selected' : '' ?>>Experts</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="description">Description</label>
                <textarea class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus resize-none leading-relaxed" name="description" rows="4"><?= htmlspecialchars($game['description'] ?? '') ?></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="difficulty">Difficulté</label>
                    <div class="flex items-center gap-4 bg-surface-container-high p-4 rounded-lg">
                        <input class="flex-grow accent-primary h-2 rounded-full cursor-pointer" name="difficulty" max="5" min="1" type="range" value="<?= $game['difficulty'] ?? 3 ?>"/>
                        <span class="text-primary font-bold text-lg w-4"><?= $game['difficulty'] ?? 3 ?></span>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="duration_minutes">Durée (minutes)</label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" name="duration_minutes" type="number" value="<?= $game['duration_minutes'] ?? 60 ?>"/>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="min_players">Joueurs min</label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" name="min_players" type="number" value="<?= $game['min_players'] ?? 2 ?>"/>
                </div>
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="max_players">Joueurs max</label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" name="max_players" type="number" value="<?= $game['max_players'] ?? 4 ?>"/>
                </div>
            </div>
            
            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>
            
            <div class="pt-4 space-y-4">
                <button class="w-full btn-primary font-bold py-4 px-6 rounded-lg transition-all flex items-center justify-center gap-2" type="submit">
                    <span class="material-symbols-outlined">save</span>
                    Enregistrer les modifications
                </button>
                <a href="<?= BASE_URL ?>/games/<?= $game['id'] ?>" class="w-full border-2 border-error text-error font-bold py-4 px-6 rounded-lg hover:bg-error/10 transition-all flex items-center justify-center gap-2 text-center">
                    <span class="material-symbols-outlined">close</span>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</main>