<?php require __DIR__ . '/../layouts/header.php'; ?>

<nav class="fixed top-0 w-full z-50 glass-nav shadow-[0_40px_40px_rgba(233,195,73,0.08)]">
    <div class="flex justify-between items-center px-8 h-16 w-full">
        <div class="text-xl font-black text-primary tracking-tighter font-headline">Aji L3bo Admin</div>
        <div class="hidden md:flex space-x-8 items-center">
            <a class="text-zinc-500 hover:text-zinc-300 transition-colors font-headline tracking-tight font-bold text-sm" href="/sessions/dashboard">Dashboard</a>
            <a class="text-primary border-b-2 border-primary pb-1 font-headline tracking-tight font-bold text-sm" href="/sessions/create">Sessions</a>
            <a class="text-zinc-500 hover:text-zinc-300 transition-colors font-headline tracking-tight font-bold text-sm" href="/games">Inventory</a>
        </div>
        <div class="flex items-center space-x-4">
            <button class="material-symbols-outlined text-zinc-400 hover:text-primary transition-all active:scale-95">notifications</button>
            <button class="material-symbols-outlined text-zinc-400 hover:text-primary transition-all active:scale-95">settings</button>
        </div>
    </div>
</nav>

<main class="flex-grow flex items-center justify-center pt-24 pb-12 px-6">
    <div class="w-full max-w-xl">
        <div class="mb-10 text-center relative">
            <h1 class="text-4xl md:text-5xl font-black text-on-surface tracking-tighter mb-2">Démarrer une session</h1>
            <p class="text-zinc-500 font-medium text-lg">Associer une réservation à un jeu</p>
            <div class="absolute -top-6 -left-6 w-12 h-12 border-t-2 border-l-2 border-primary/20 opacity-50"></div>
            <div class="absolute -bottom-6 -right-6 w-12 h-12 border-b-2 border-r-2 border-primary/20 opacity-50"></div>
        </div>

        <div class="bg-surface-container-low rounded-xl overflow-hidden border border-outline-variant/10 shadow-2xl relative">
            <div class="h-1 bg-gradient-to-r from-transparent via-primary/30 to-transparent w-full"></div>
            
            <?php if (!empty($errors)): ?>
                <div class="error-box">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/sessions" class="p-8 md:p-10 space-y-8">
                <div class="space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary/80 px-1">Réservation confirmée</label>
                    <div class="relative group">
                        <select class="w-full bg-surface-container-high border-none rounded-lg py-4 px-4 text-on-surface focus:ring-2 focus:ring-primary/50 transition-all appearance-none cursor-pointer" name="reservation_id">
                            <?php foreach ($availableReservations as $res): ?>
                                <option value="<?= $res['id'] ?>"><?= htmlspecialchars($res['user_name']) ?> — Table <?= $res['table'] ?> — <?= $res['date'] ?> à <?= $res['time'] ?> (<?= $res['duration'] ?>h, <?= $res['people_count'] ?> pers.)</option>
                            <?php endforeach; ?>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-500 group-focus-within:text-primary">expand_more</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary/80 px-1">Jeu disponible</label>
                    <div class="relative group">
                        <select class="w-full bg-surface-container-high border-none rounded-lg py-4 px-4 text-on-surface focus:ring-2 focus:ring-primary/50 transition-all appearance-none cursor-pointer" name="game_id">
                            <?php foreach ($availableGames as $game): ?>
                                <option value="<?= $game['id'] ?>"><?= htmlspecialchars($game['name']) ?> (<?= htmlspecialchars($game['category']) ?> · <?= $game['players_min'] ?>-<?= $game['players_max'] ?> joueurs)</option>
                            <?php endforeach; ?>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-500 group-focus-within:text-primary">casino</span>
                    </div>
                </div>

                <?php if (!empty($_SESSION['csrf_token'])): ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php endif; ?>

                <div class="pt-4 space-y-4">
                    <button class="w-full success-gradient hover:brightness-110 active:scale-[0.98] transition-all text-background font-black py-4 rounded-xl flex items-center justify-center space-x-2 shadow-lg shadow-success-accent/10" type="submit">
                        <span class="material-symbols-outlined fill font-bold" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                        <span>Démarrer la session</span>
                    </button>
                    <a href="/sessions/dashboard" class="w-full bg-transparent border border-outline-variant/30 hover:bg-white/5 text-zinc-400 hover:text-white font-bold py-4 rounded-xl transition-all active:scale-[0.98] block text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
        <p class="mt-8 text-center text-zinc-600 text-xs font-medium uppercase tracking-[0.2em]">
            Aji L3bo Café — Système de Gestion d'Alchimie Sociale
        </p>
    </div>
</main>
