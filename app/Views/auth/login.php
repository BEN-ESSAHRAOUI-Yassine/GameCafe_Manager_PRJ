<main class="flex-grow flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary/10 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/5 blur-[150px]"></div>
    </div>

    <div class="w-full max-w-md z-10">
        <div class="bg-surface-container-low rounded-xl overflow-hidden p-8 border border-outline-variant/15">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-1-5 mb-6 rounded-full bg-primary/10 border border-primary/20">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-xs tracking-widest uppercase text-primary">GameCafe</span>
                </div>
                <h1 class="font-headline text-4xl font-extrabold text-primary tracking-tighter mb-2">
                    Welcome Back
                </h1>
                <p class="font-body text-on-surface-variant opacity-80">
                    Connectez-vous pour continuer
                </p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="error-box">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="<?= BASE_URL ?>/login">
                <div class="space-y-2">
                    <label class="block font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70 ml-1" for="email">Email</label>
                    <input
                        class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus"
                        id="email" name="email" placeholder="votre@email.com" type="email"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required/>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label class="font-label text-xs uppercase tracking-widest text-on-surface-variant opacity-70" for="password">Mot de passe</label>
                        <a class="text-xs text-primary hover-opacity transition-all" href="#">Oublié ?</a>
                    </div>
                    <input
                        class="w-full bg-surface-container-high border-none rounded-lg py-4 px-5 text-on-surface outline-none input-focus"
                        id="password" name="password" placeholder="••••••••" type="password" required/>
                </div>

                <div class="flex items-center gap-2">
                    <input class="w-4 h-4 rounded bg-surface-container-highest" id="remember" name="remember" type="checkbox"/>
                    <label class="text-sm text-on-surface-variant" for="remember">Se souvenir de moi</label>
                </div>

                <?php if (!empty($_SESSION['csrf_token'])): ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php endif; ?>

                <button class="w-full py-4 btn-primary font-headline font-bold text-lg rounded-lg transition-all" type="submit">
                    Se connecter
                </button>
            </form>

            <div class="mt-10 text-center">
                <p class="font-body text-sm text-on-surface-variant">
                    Pas encore de compte ?
                    <a class="text-primary font-bold hover-opacity transition-colors ml-1" href="<?= BASE_URL ?>/register">S'inscrire</a>
                </p>
            </div>
        </div>

        <div class="mt-8 text-center text-xs uppercase tracking-widest opacity-40 text-on-surface-variant">
            <p>© 2026 GameCafe. All rights reserved.</p>
        </div>
    </div>
</main>
