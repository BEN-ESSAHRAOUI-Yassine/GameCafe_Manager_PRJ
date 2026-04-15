<main class="flex-grow flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>
    
    <div class="w-full max-w-2xl z-10">
        <div class="bg-surface-container-low rounded-xl overflow-hidden p-8 md:p-12 border border-outline-variant/15">
            <header class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 rounded-full bg-primary/10 border border-primary/20">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-xs tracking-widest uppercase text-primary">Réservation</span>
                </div>
                <h1 class="text-4xl font-extrabold text-on-surface font-headline tracking-tighter mb-2">Nouvelle Réservation</h1>
                <p class="text-on-surface-variant font-body opacity-80">Réservez votre table pour une expérience ludique unique.</p>
            </header>
        
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/reservations" class="space-y-6">
            <div class="space-y-2">
                <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="party_size">Nombre de personnes</label>
                <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" id="party_size" name="party_size" placeholder="2" type="number" min="1" max="10"/>
            </div>
            
            <div class="space-y-2">
                <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="reserved_at">Date</label>
                <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" id="reserved_at" name="reserved_at" type="datetime-local"/>
            </div>
            
            <div class="space-y-2">
                <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="duration_hours">Durée souhaitée</label>
                <div class="relative">
                    <select class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus appearance-none cursor-pointer" id="duration_hours" name="duration_hours">
                        <option value="1">1 heure</option>
                        <option value="2">2 heures</option>
                        <option value="3">3 heures</option>
                        <option value="4">4 heures</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                </div>
            </div>
            
            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>
            
            <button class="w-full py-4 btn-primary font-headline font-bold text-lg rounded-lg transition-all mt-4" type="submit">
                <span class="material-symbols-outlined mr-2">search_check</span>
                Vérifier la disponibilité
            </button>
        </form>
    </div>
</main>