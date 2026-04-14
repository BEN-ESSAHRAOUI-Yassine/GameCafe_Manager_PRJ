<main class="flex-grow flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="w-full max-w-[440px] z-10">
        <div class="mb-12 text-center md:text-left relative">
            <span class="inline-block px-3 py-1 mb-6 rounded-full bg-surface-container-highest text-primary font-label text-xs tracking-widest uppercase border border-outline-variant/20">Accès Membre</span>
            <h1 class="text-5xl font-headline font-black text-primary tracking-tighter leading-none mb-2">
                Aji L3bo 🎲
            </h1>
            <p class="text-on-surface-variant font-body text-lg">Connectez-vous à votre compte</p>
        </div>
        <div class="bg-surface-container-low rounded-xl p-8 md:p-10 border border-outline-variant/10 shadow-[0_40px_0px_8%_rgba(233,195,73,0.03)]">
            <?php if (!empty($errors)): ?>
                <div class="error-box">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form class="space-y-8" method="POST" action="/login">
                <div class="space-y-3">
                    <label class="block font-label text-sm font-semibold text-on-surface/70 tracking-wide uppercase" for="email">Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">mail</span>
                        <input class="w-full bg-surface-container-high border-outline-variant/20 focus:border-primary focus:ring-0 rounded-lg py-4 pl-12 pr-4 text-on-surface placeholder:text-neutral-600 transition-all outline-none" id="email" name="email" placeholder="votre@email.com" type="email"/>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <label class="block font-label text-sm font-semibold text-on-surface/70 tracking-wide uppercase" for="password">Mot de passe</label>
                        <a class="text-xs font-medium text-primary/80 hover:text-primary transition-colors" href="#">Oublié ?</a>
                    </div>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">lock</span>
                        <input class="w-full bg-surface-container-high border-outline-variant/20 focus:border-primary focus:ring-0 rounded-lg py-4 pl-12 pr-12 text-on-surface placeholder:text-neutral-600 transition-all outline-none" id="password" name="password" placeholder="••••••••" type="password"/>
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface" type="button">
                            <span class="material-symbols-outlined">visibility</span>
                        </button>
                    </div>
                </div>
                <?php if (!empty($_SESSION['csrf_token'])): ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php endif; ?>
                <button class="group relative w-full bg-primary hover:bg-primary-container text-on-primary font-headline font-extrabold text-lg py-5 rounded-xl transition-all duration-300 shadow-xl shadow-primary/10 flex items-center justify-center gap-2 overflow-hidden active:scale-[0.98]" type="submit">
                    <span class="relative z-10">Se connecter</span>
                    <span class="material-symbols-outlined relative z-10 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary via-transparent to-surface-tint opacity-30"></div>
                </button>
            </form>
            <div class="mt-10 pt-8 border-t border-outline-variant/10 text-center">
                <p class="text-on-surface-variant text-sm font-body">
                    Pas encore de compte ? 
                    <a class="text-primary font-bold ml-1 hover:underline underline-offset-4 decoration-2 decoration-primary/30 transition-all" href="/register">S'inscrire</a>
                </p>
            </div>
        </div>
        <div class="mt-12 flex justify-center items-center gap-8 opacity-40">
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined text-sm">coffee</span>
                <span class="text-xs font-label uppercase tracking-[0.2em]">Artisan Brews</span>
            </div>
            <div class="w-1 h-1 bg-outline-variant rounded-full"></div>
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined text-sm">casino</span>
                <span class="text-xs font-label uppercase tracking-[0.2em]">Curated Games</span>
            </div>
        </div>
    </div>
</main>