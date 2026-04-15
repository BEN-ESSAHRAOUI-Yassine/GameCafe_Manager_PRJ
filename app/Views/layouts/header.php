<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/Style.css">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@700;800;900&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="bg-surface text-on-surface font-body min-h-screen flex flex-col">
    <header class="fixed top-0 left-0 w-full z-50 bg-surface-dim/80 backdrop-blur-xl border-b border-outline-variant/10">
        <div class="flex items-center justify-between w-full px-4 md:px-12 py-4">
            <a href="<?= BASE_URL ?>/" class="flex items-center gap-2">
                <span class="text-xl">🎲</span>
                <span class="font-headline font-bold text-lg tracking-tight text-primary">Aji L3bo Café</span>
            </a>
            <nav class="flex items-center gap-6">
                <a href="<?= BASE_URL ?>/games" class="text-on-surface-variant hover:text-primary transition-colors font-medium">Jeux</a>
                <?php if (\Core\Controller::isAdmin()): ?>
                    <a href="<?= BASE_URL ?>/reservations" class="text-on-surface-variant hover:text-primary transition-colors font-medium">Réservations</a>
                <?php elseif (\Core\Controller::isLoggedIn()): ?>
                    <a href="<?= BASE_URL ?>/reservations/my-reservations" class="text-on-surface-variant hover:text-primary transition-colors font-medium">Mes Réservations</a>
                <?php endif; ?>
                <?php if (\Core\Controller::isLoggedIn()): ?>
                    <a href="<?= BASE_URL ?>/logout" class="text-on-surface-variant hover:text-error transition-colors font-medium">Déconnexion</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/login" class="text-on-surface-variant hover:text-primary transition-colors font-medium">Connexion</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <div class="h-20"></div>
