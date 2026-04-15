<main class="flex-grow flex items-center justify-center pt-24 pb-12 px-6 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>
    
    <div class="w-full max-w-xl z-10">
        <div class="mb-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 rounded-full bg-primary/10 border border-primary/20">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-xs tracking-widest uppercase text-primary">Sessions</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-on-surface tracking-tighter mb-2">Démarrer une session</h1>
            <p class="text-on-surface-variant font-medium text-lg">Associer une réservation à un jeu</p>
        </div>

        <div class="bg-surface-container-low rounded-xl overflow-hidden p-8 md:p-10 border border-outline-variant/15">
            <?php if (!empty($errors)): ?>
                <div class="error-box">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/sessions" class="space-y-6">
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="reservation_id">Réservation confirmée</label>
                    <div class="relative">
                        <select class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus appearance-none cursor-pointer" id="reservation_id" name="reservation_id">
                            <?php foreach ($reservations ?? $availableReservations ?? [] as $res): ?>
                                <option value="<?= $res['id'] ?>">
                                    <?= htmlspecialchars($res['client_name'] ?? $res['user_name'] ?? 'Client') ?> — 
                                    Table <?= htmlspecialchars($res['table_name'] ?? $res['table']) ?> — 
                                    <?= htmlspecialchars(date('d/m H:i', strtotime($res['reserved_at'] ?? $res['date']))) ?> 
                                    (<?= $res['duration_hours'] ?? $res['duration'] ?? 1 ?>h, <?= $res['party_size'] ?? $res['people_count'] ?? 1 ?> pers.)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="game_id">Jeu disponible</label>
                    <div class="relative">
                        <select class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus appearance-none cursor-pointer" id="game_id" name="game_id">
                            <?php foreach ($games ?? $availableGames ?? [] as $game): ?>
                                <option value="<?= $game['id'] ?>"><?= htmlspecialchars($game['name']) ?> (<?= htmlspecialchars($game['category']) ?> · <?= $game['min_players'] ?>-<?= $game['max_players'] ?> joueurs)</option>
                            <?php endforeach; ?>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                    </div>
                </div>

                <?php if (!empty($_SESSION['csrf_token'])): ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php endif; ?>

                <div class="pt-4 space-y-4">
                    <button class="w-full py-4 btn-primary font-headline font-bold text-lg rounded-lg transition-all flex items-center justify-center gap-2" type="submit">
                        <span class="material-symbols-outlined">play_arrow</span>
                        Démarrer la session
                    </button>
                    <a href="/sessions/dashboard" class="w-full py-4 bg-transparent border border-outline-variant/30 hover:border-primary hover:text-primary text-on-surface-variant font-bold rounded-lg transition-all block text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>