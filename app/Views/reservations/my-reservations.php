<?php require __DIR__ . '/../layouts/header.php'; ?>

<nav class="fixed top-0 w-full z-50 bg-[#131313]/60 backdrop-blur-xl bg-gradient-to-b from-[#1c1b1b] to-transparent shadow-[0_40px_0_8%_rgba(233,195,73,0.08)] flex justify-between items-center px-8 h-20">
    <div class="text-2xl font-bold tracking-tighter text-[#D4AF37] font-headline">Aji L3bo Café</div>
    <div class="hidden md:flex items-center gap-8">
        <a class="text-gray-400 font-medium font-headline hover:text-[#F2CA50] transition-colors duration-300" href="/games">Games</a>
        <a class="text-[#D4AF37] border-b-2 border-[#D4AF37] pb-1 font-headline hover:text-[#F2CA50] transition-colors duration-300" href="/reservations">Reservations</a>
        <a class="text-gray-400 font-medium font-headline hover:text-[#F2CA50] transition-colors duration-300" href="/sessions/dashboard">Dashboard</a>
    </div>
    <div class="flex items-center gap-6">
        <button class="text-[#D4AF37] hover:text-[#F2CA50] transition-colors active:scale-95 transition-transform">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <button class="text-[#D4AF37] hover:text-[#F2CA50] transition-colors active:scale-95 transition-transform">
            <span class="material-symbols-outlined">account_circle</span>
        </button>
    </div>
</nav>

<main class="min-h-screen pt-32 pb-24 px-4 md:px-8 max-w-7xl mx-auto">
    <header class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <h1 class="font-headline text-4xl md:text-5xl font-extrabold tracking-tight text-on-surface mb-2">Mes Réservations</h1>
            <p class="text-on-surface-variant font-medium text-lg italic">Historique de vos réservations</p>
        </div>
        <a href="/reservations/create" class="inline-flex items-center gap-2 bg-primary text-on-primary-fixed px-6 py-3 rounded-xl font-bold hover:bg-primary-fixed transition-colors active:scale-95 transition-transform shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined">add_circle</span>
            + Nouvelle Réservation
        </a>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-8xl">event_available</span>
            </div>
            <p class="text-on-surface-variant label-sm mb-1 uppercase tracking-widest font-semibold">Prochaine</p>
            <p class="text-primary font-headline text-2xl font-bold"><?= htmlspecialchars($nextReservation['date'] ?? '—') ?></p>
            <p class="text-on-surface/60 text-sm mt-1">Table <?= htmlspecialchars($nextReservation['table'] ?? '—') ?> • <?= htmlspecialchars($nextReservation['time'] ?? '—') ?></p>
        </div>
        <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-8xl">history</span>
            </div>
            <p class="text-on-surface-variant label-sm mb-1 uppercase tracking-widest font-semibold">Total Sessions</p>
            <p class="text-on-surface font-headline text-2xl font-bold"><?= $totalHours ?? 0 ?> Heures</p>
            <p class="text-on-surface/60 text-sm mt-1">Depuis votre inscription</p>
        </div>
        <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-8xl">stars</span>
            </div>
            <p class="text-on-surface-variant label-sm mb-1 uppercase tracking-widest font-semibold">Fidélité</p>
            <p class="text-surface-tint font-headline text-2xl font-bold">Membre <?= htmlspecialchars($membershipLevel ?? 'Standard') ?></p>
            <p class="text-on-surface/60 text-sm mt-1">5% de réduction sur boissons</p>
        </div>
    </div>

    <div class="bg-surface-container-low rounded-xl overflow-hidden border border-outline-variant/10 shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-high text-on-surface-variant font-headline uppercase text-xs tracking-widest">
                        <th class="px-8 py-5 font-bold">Date</th>
                        <th class="px-8 py-5 font-bold">Heure</th>
                        <th class="px-8 py-5 font-bold">Durée</th>
                        <th class="px-8 py-5 font-bold">Table</th>
                        <th class="px-8 py-5 font-bold">Personnes</th>
                        <th class="px-8 py-5 font-bold">Statut</th>
                        <th class="px-8 py-5 font-bold"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    <?php foreach ($reservations as $reservation): ?>
                        <tr class="hover:bg-surface-variant transition-colors group">
                            <td class="px-8 py-6 font-semibold text-on-surface"><?= htmlspecialchars($reservation['date']) ?></td>
                            <td class="px-8 py-6 font-medium text-on-surface-variant"><?= htmlspecialchars($reservation['time']) ?></td>
                            <td class="px-8 py-6 font-medium text-on-surface-variant"><?= $reservation['duration'] ?>h</td>
                            <td class="px-8 py-6">
                                <span class="bg-surface-container-highest px-3 py-1 rounded text-sm font-medium border border-outline-variant/20">Table <?= htmlspecialchars($reservation['table']) ?></span>
                            </td>
                            <td class="px-8 py-6 font-medium text-on-surface-variant"><?= $reservation['people_count'] ?> personnes</td>
                            <td class="px-8 py-6">
                                <?php if ($reservation['status'] === 'pending'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-500/10 text-green-400 border border-green-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                                        À venir
                                    </span>
                                <?php elseif ($reservation['status'] === 'confirmed'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        Confirmée
                                    </span>
                                <?php elseif ($reservation['status'] === 'completed'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                        Complétée
                                    </span>
                                <?php elseif ($reservation['status'] === 'cancelled'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-error/10 text-error border border-error/20">
                                        Annulée
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button class="opacity-0 group-hover:opacity-100 te
