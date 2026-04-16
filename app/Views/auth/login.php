<main class="auth-page">
    <div class="auth-bg">
        <div class="auth-bg-shape auth-bg-shape-1"></div>
        <div class="auth-bg-shape auth-bg-shape-2"></div>
    </div>

    <div class="auth-card">
        <div class="auth-logo">
            <span class="material-icons">casino</span>
        </div>
        
        <h1 class="auth-title">Bon retour</h1>
        <p class="auth-subtitle">Connectez-vous pour continuer</p>

        <?php if (!empty($errors)): ?>
            <div class="form-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/login">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" 
                       placeholder="votre@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <div class="flex justify-between items-center">
                    <label class="form-label" for="password">Mot de passe</label>
                    <a href="#" style="font-size: 0.75rem; color: var(--text-muted);">Oublié ?</a>
                </div>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <div class="form-checkbox">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Se souvenir de moi</label>
                </div>
            </div>

            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>

            <button type="submit" class="btn btn-primary btn-block">
                Se connecter
            </button>
        </form>

        <div class="auth-footer">
            <p>Pas de compte ? <a href="<?= BASE_URL ?>/register">S'inscrire</a></p>
        </div>
    </div>

    <p class="auth-copyright">© 2026 Aji L3bo Café</p>
</main>