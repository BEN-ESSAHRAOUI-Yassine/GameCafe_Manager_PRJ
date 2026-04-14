<main class="flex-grow flex items-center justify-center px-6 relative">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] -z-10"></div>
    
    <div class="w-full max-w-2xl alchemist-card rounded-lg p-8 md:p-12 ghost-border">
        <header class="mb-10">
            <h1 class="text-4xl font-extrabold text-on-surface font-headline tracking-tighter mb-2">Nouvelle Réservation</h1>
            <p class="text-on-surface-variant font-body">Réservez votre table pour une expérience ludique unique.</p>
        </header>
        
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/reservations" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-on-surface-variant tracking-wide">Nombre de personnes</label>
                    <div class="relative group">
                        <input class="w-full bg-surface-container-high border-0 rounded-lg py-4 px-5 text-on-surface focus:ring-2 focus:ring-primary/50 transition-all placeholder:text-zinc-600" name="party_size" placeholder="2" type="number" min="1" max="10"/>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-zinc-600 group-focus-within:text-primary transition-colors">group</span>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-on-surface-variant tracking-wide">Date</label>
                    <div class="relative group">
                        <input class="w-full bg-surface-container-high border-0 rounded-lg py-4 px-5 text-on-surface focus:ring-2 focus:ring-primary/50 transition-all" name="reserved_at" type="datetime-local"/>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-on-surface-variant tracking-wide">Durée souhaitée</label>
                    <select class="w-full bg-surface-container-high border-0 rounded-lg py-4 px-5 text-on-surface focus:ring-2 focus:ring-primary/50 transition-all appearance-none" name="duration_hours">
                        <option value="1">1 heure</option>
                        <option value="2">2 heures</option>
                        <option value="3">3 heures</option>
                        <option value="4">4 heures</option>
                    </select>
                </div>
            </div>
            
            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>
            
            <button class="w-full teal-accent font-bold py-4 rounded-lg flex items-center justify-center gap-3 hover:opacity-90 active:scale-[0.98] transition-all font-body text-lg shadow-lg shadow-teal-500/10" type="submit">
                <span class="material-symbols-outlined">search_check</span>
                Vérifier la disponibilité
            </button>
        </form>
    </div>
</main>