<main class="auth-page">
    <div class="auth-bg">
        <div class="auth-bg-shape auth-bg-shape-1"></div>
        <div class="auth-bg-shape auth-bg-shape-2"></div>
    </div>

    <div class="auth-card">
        <div class="auth-logo">
            <span class="material-icons">casino</span>
        </div>
        
        <h1 class="auth-title">Créer un compte</h1>
        <p class="auth-subtitle">Rejoignez l'aventure</p>

        <?php if (!empty($errors)): ?>
            <div class="form-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/register">
            <div class="form-group">
                <label class="form-label" for="name">Nom complet</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="Votre nom" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="votre@email.com" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Téléphone</label>
                <input type="tel" id="phone" name="phone" class="form-input" placeholder="06 00 00 00 00" required>
            </div>

            <div class="flex gap-3">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Min. 8 car." required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="password_confirm">Confirmer</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-input" placeholder="Confirmer" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">J'accepte les conditions d'utilisation</label>
                </div>
            </div>

            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>

            <button type="submit" class="btn btn-primary btn-block">
                S'inscrire
            </button>
        </form>

        <div class="auth-footer">
            <p>Déjà un compte ? <a href="<?= BASE_URL ?>/login">Se connecter</a></p>
        </div>
        
        <p class="auth-copyright">© 2026 Aji L3bo Café</p>
    </div>
</main>