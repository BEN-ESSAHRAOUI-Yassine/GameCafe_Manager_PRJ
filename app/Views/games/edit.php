

<nav class="fixed top-0 left-0 right-0 z-50 bg-[#131313]/60 backdrop-blur-xl flex justify-between items-center w-full px-8 py-4 max-w-full mx-auto shadow-[0_40px_40px_rgba(233,195,73,0.08)]">
    <div class="flex items-center gap-8">
        <span class="text-2xl font-bold tracking-tighter text-[#d4af37] font-[Epilogue]">Aji L3bo Café</span>
        <div class="hidden md:flex items-center gap-6">
            <a class="text-neutral-400 font-medium hover:text-[#f2ca50] transition-colors duration-300" href="/sessions/dashboard">Dashboard</a>
            <a class="text-neutral-400 font-medium hover:text-[#f2ca50] transition-colors duration-300" href="/reservations">Bookings</a>
            <a class="text-[#d4af37] border-b-2 border-[#d4af37] pb-1 font-bold transition-colors duration-300" href="/games">Inventory</a>
            <a class="text-neutral-400 font-medium hover:text-[#f2ca50] transition-colors duration-300" href="#">Members</a>
            <a class="text-neutral-400 font-medium hover:text-[#f2ca50] transition-colors duration-300" href="#">Reports</a>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined">settings</span>
        </button>
    </div>
</nav>

<main class="flex-grow flex items-center justify-center pt-24 pb-12 px-4">
    <div class="w-full max-w-2xl bg-surface-container-low p-8 md:p-12 rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-outline-variant/10 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary-container to-transparent opacity-50"></div>
        
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-on-background mb-2">Modifier le jeu</h1>
            <p class="text-on-surface-variant font-medium tracking-wide">Mettre à jour les informations</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/games/<?= $game['id'] ?>/update" class="space-y-6">
            <div>
                <label class="block text-sm font-bold uppercase tracking-widest text-[#d4af37] mb-2 font-label">Nom du jeu</label>
                <input class="w-full bg-surface-container-high border-none rounded-lg p-4 text-on-surface focus:ring-2 focus:ring-primary-container transition-all duration-300 outline-none placeholder:text-neutral-600" name="name" type="text" value="<?= htmlspecialchars($game['name'] ?? '') ?>"/>
            </div>
            
            <div>
                <label class="block text-sm font-bold uppercase tracking-widest text-[#d4af37] mb-2 font-label">Catégorie</label>
                <div class="relative">
                    <select class="w-full bg-surface-container-high border-none rounded-lg p-4 text-on-surface focus:ring-2 focus:ring-primary-container transition-all duration-300 appearance-none outline-none" name="category">
                        <option value="strategie" <?= ($game['category'] ?? '') === 'strategie' ? 'selected' : '' ?>>Stratégie</option>
                        <option value="famille" <?= ($game['category'] ?? '') === 'famille' ? 'selected' : '' ?>>Famille</option>
                        <option value="ambiance" <?= ($game['category'] ?? '') === 'ambiance' ? 'selected' : '' ?>>Ambiance</option>
                        <option value="experts" <?= ($game['category'] ?? '') === 'experts' ? 'selected' : '' ?>>Experts</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-neutral-500">expand_more</span>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-bold uppercase tracking-widest text-[#d4af37] mb-2 font-label">Description</label>
                <textarea class="w-full bg-surface-container-high border-none rounded-lg p-4 text-on-surface focus:ring-2 focus:ring-primary-container transition-all duration-300 outline-none resize-none leading-relaxed" name="description" rows="4"><?= htmlspecialchars($game['description'] ?? '') ?></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest text-[#d4af37] mb-2 font-label">Difficulté</label>
                    <div class="flex items-center gap-4 bg-surface-container-high p-4 rounded-lg">
                        <input class="flex-grow accent-primary-container h-2 rounded-full cursor-pointer" name="difficulty" max="5" min="1" type="range" value="<?= $game['difficulty'] ?? 3 ?>"/>
                        <span class="text-primary-container font-bold text-lg w-4"><?= $game['difficulty'] ?? 3 ?></span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest text-[#d4af37] mb-2 font-label">Durée estimée (minutes)</label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg p-4 text-on-surface focus:ring-2 focus:ring-primary-container transition-all duration-300 outline-none" name="duration" type="number" value="<?= $game['duration'] ?? 60 ?>"/>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest text-[#d4af37] mb-2 font-label">Joueurs min</label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg p-4 text-on-surface focus:ring-2 focus:ring-primary-container transition-all duration-300 outline-none" name="players_min" type="number" value="<?= $game['players_min'] ?? 2 ?>"/>
                </div>
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest text-[#d4af37] mb-2 font-label">Joueurs max</label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg p-4 text-on-surface focus:ring-2 focus:ring-primary-container transition-all duration-300 outline-none" name="players_max" type="number" value="<?= $game['players_max'] ?? 4 ?>"/>
                </div>
            </div>
            
            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>
            
            <div class="pt-6 space-y-4">
                <button class="w-full bg-primary-container text-on-primary-container font-bold py-4 px-6 rounded-lg hover:bg-primary transition-all duration-300 transform active:scale-95 shadow-lg flex items-center justify-center gap-2" type="submit">
                    <span class="material-symbols-outlined">save</span>
                    Enregistrer les modifications
                </button>
                <a href="/games/<?= $game['id'] ?>" class="w-full border-2 border-error text-error font-bold py-4 px-6 rounded-lg hover:bg-error/10 transition-all duration-300 transform active:scale-95 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">close</span>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</main>
