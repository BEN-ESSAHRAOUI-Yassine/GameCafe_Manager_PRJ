<main class="flex-grow flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>

    <div class="w-full max-w-lg z-10">
        <div class="bg-surface-container-low rounded-xl overflow-hidden p-8 md:p-12 border border-outline-variant/15">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 rounded-full bg-primary/10 border border-primary/20">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-xs tracking-widest uppercase text-primary">GameCafe</span>
                </div>
                <h1 class="font-headline text-4xl font-extrabold text-primary tracking-tighter mb-2">
                    Créer un compte
                </h1>
                <p class="font-body text-on-surface-variant opacity-80">
                    Rejoignez l'aventure
                </p>
            </div>
            <?php if (!empty($errors)): ?>
                <div class="error-box">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="<?= BASE_URL ?>/register" method="POST" class="space-y-6">
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="name">Nom complet</label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" placeholder="Votre nom" type="text" name="name" id="name" required/>
                </div>
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="email">Email</label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" placeholder="votre@email.com" type="email" name="email" id="email" required/>
                </div>
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="phone">Téléphone</label>
                    <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" placeholder="06 00 00 00 00" type="tel" name="phone" id="phone" required/>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="password">Mot de passe</label>
                        <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" placeholder="Min. 8 caractères" type="password" name="password" id="password" required/>
                    </div>
                    <div class="space-y-2">
                        <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="password_confirm">Confirmer</label>
                        <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus" placeholder="Confirmer" type="password" name="password_confirm" id="password_confirm" required/>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <input class="w-5 h-5 rounded bg-surface-container-highest" id="terms" type="checkbox" name="terms" required/>
                    <label class="text-xs text-on-surface-variant leading-relaxed" for="terms">
                        J'accepte les conditions d'utilisation
                    </label>
                </div>
                <?php if (!empty($_SESSION['csrf_token'])): ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php endif; ?>
                <div class="pt-4">
                    <button class="w-full py-4 btn-primary font-headline font-bold text-lg rounded-lg transition-all" type="submit">
                        S'inscrire
                    </button>
                </div>
            </form>
            <div class="mt-10 text-center">
                <p class="font-body text-sm text-on-surface-variant">
                    Déjà un compte ?
                    <a class="text-primary font-bold hover-opacity transition-colors ml-1" href="<?= BASE_URL ?>/login">Se connecter</a>
                </p>
            </div>
        </div>

        <div class="mt-8 text-center text-xs uppercase tracking-widest opacity-40 text-on-surface-variant">
            <p>© 2026 GameCafe. All rights reserved.</p>
        </div>
    </div>
</main>