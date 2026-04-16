<main class="main-content" style="display: flex; justify-content: center; padding-top: 2rem;">
    <div class="card" style="max-width: 450px; width: 100%;">
        <div style="text-align: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem;">
            <div class="stat-chip" style="margin: 0 auto 1rem;">
                <span class="dot gold"></span>
                <span>Réservation</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Nouvelle Réservation</h1>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Réservez votre table pour jouer</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="form-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?= BASE_URL ?>/reservations">
            <div class="form-group">
                <label class="form-label" for="party_size">Nombre de personnes</label>
                <input type="number" id="party_size" name="party_size" class="form-input" min="1" max="10" placeholder="2"/>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="reserved_at">Date et heure</label>
                <input type="datetime-local" id="reserved_at" name="reserved_at" class="form-input"/>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="duration_hours">Durée</label>
                <select id="duration_hours" name="duration_hours" class="form-select">
                    <option value="1">1h</option>
                    <option value="2">2h</option>
                    <option value="3">3h</option>
                    <option value="4">4h</option>
                </select>
            </div>
            
            <?php if (!empty($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>
            
            <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <span class="material-icons">search_check</span>
                    Vérifier dispo
                </button>
                <a href="<?= BASE_URL ?>/reservations/my" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</main>