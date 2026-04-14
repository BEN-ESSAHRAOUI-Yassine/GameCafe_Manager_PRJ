<main class="flex-grow flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-surface-tint/5 blur-[150px]"></div>
    </div>
    <div class="w-full max-w-lg z-10">
        <div class="bg-surface-container-low rounded-xl editorial-shadow overflow-hidden p-8 md:p-12 border border-outline-variant/15">
            <div class="text-center mb-10">
                <h1 class="font-headline text-4xl font-extrabold text-primary tracking-tighter mb-2">
                    Aji L3bo 🎲
                </h1>
                <p class="font-body text-on-surface-variant tracking-wide opacity-80">
                    Créer un nouveau compte
                </p>
            </div>
            <?php if (!empty($errors)): ?>
                <div class="error-box">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="/register" method="POST" class="space-y-6">
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant/70 ml-1">Nom complet</label>
                    <div class="relative">
                        <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/50 transition-all outline-none" placeholder="Votre nom" type="text" name="name"/>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant/70 ml-1">Email</label>
                    <div class="relative">
                        <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/50 transition-all outline-none" placeholder="votre@email.com" type="email" name="email"/>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant/70 ml-1">Téléphone</label>
                    <div class="relative">
                        <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/50 transition-all outline-none" placeholder="06 00 00 00 00" type="tel" name="phone"/>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant/70 ml-1">Mot de passe</label>
                        <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/50 transition-all outline-none" placeholder="Min. 8 caractères" type="password" name="password"/>
                    </div>
                    <div class="space-y-2">
                        <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant/70 ml-1">Confirmer</label>
                        <input class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/50 transition-all outline-none" placeholder="Confirmer" type="password" name="password_confirm"/>
                    </div>
                </div>
                <div class="flex items-center space-x-3 pt-2">
                    <input class="w-5 h-5 rounded border-none bg-surface-container-highest text-primary focus:ring-primary/50" id="terms" type="checkbox" name="terms"/>
                    <label class="text-xs text-on-surface-variant leading-relaxed" for="terms">
                        J'accepte les conditions d'utilisation et la politique de confidentialité.
                    </label>
                </div>
                <?php if (!empty($_SESSION['csrf_token'])): ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php endif; ?>
                <div class="pt-4">
                    <button class="w-full py-4 bg-gradient-to-br from-primary to-primary-container text-on-primary-fixed font-headline font-bold text-lg rounded-lg shadow-xl shadow-primary/10 hover:shadow-primary/20 active:scale-[0.98] transition-all" type="submit">
                        S'inscrire
                    </button>
                </div>
            </form>
            <div class="mt-10 text-center">
                <p class="font-body text-sm text-on-surface-variant">
                    Déjà un compte ? 
                    <a class="text-primary font-bold hover:text-surface-tint transition-colors ml-1" href="/login">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</main>