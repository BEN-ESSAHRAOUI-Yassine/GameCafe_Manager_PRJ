<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Aji L3bo Café - <?= $pageTitle ?? 'Gestion' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <script src="<?= BASE_URL ?>/js/app.js" defer></script>
</head>
<body>
    <nav class="navbar">
        <a href="<?= BASE_URL ?>/" class="navbar-brand">
            <span class="navbar-logo material-icons">casino</span>
            <span class="navbar-title">Aji L3bo Café</span>
        </a>
        <div class="navbar-nav">
            <a href="<?= BASE_URL ?>/games" class="nav-link">Jeux</a>
            <?php if (\Core\Controller::isAdmin()): ?>
                <a href="<?= BASE_URL ?>/reservations" class="nav-link">Réservations</a>
                <a href="<?= BASE_URL ?>/sessions/dashboard" class="nav-link">Sessions Dashboard</a>
                <a href="<?= BASE_URL ?>/sessions/history" class="nav-link">Sessions History</a>
            <?php elseif (\Core\Controller::isLoggedIn()): ?>
                <a href="<?= BASE_URL ?>/reservations/my" class="nav-link">Mes Réservations</a>
            <?php endif; ?>
            <?php if (\Core\Controller::isLoggedIn()): ?>
                <a href="<?= BASE_URL ?>/logout" class="nav-link btn-danger">Déconnexion</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/login" class="nav-link btn-primary">Connexion</a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="navbar-spacer"></div>
