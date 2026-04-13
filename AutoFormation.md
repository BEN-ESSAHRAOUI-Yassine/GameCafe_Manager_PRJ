# 📚 Learning Resources — Composer, Namespaces & Router

> Trois concepts fondamentaux à maîtriser pour construire le projet **Aji L3bo Café**.  
> Lis chaque section dans l'ordre — chaque concept s'appuie sur le précédent.

---

## 🧭 Vue d'ensemble

| Concept | Rôle dans le projet | Priorité |
|---|---|---|
| **Composer** | Charge automatiquement les classes sans `require_once` | 🔴 Critique |
| **Namespaces** | Organise le code en `App\Controllers`, `App\Models`… | 🔴 Critique |
| **Router** | Dirige chaque URL vers le bon Controller | 🔴 Critique |

---

## 1️⃣ Composer — PSR-4 Autoloading

### 🎯 Objectif
- Supprimer tous les `require_once` manuels
- Charger automatiquement n'importe quelle classe à partir de son namespace

### 📖 Ressources

| Type | Lien |
|---|---|
| 📄 Documentation officielle | [getcomposer.org/doc](https://getcomposer.org/doc/) |
| 🎥 Vidéo — Autoload PSR-4 explained | [youtube.com/watch?v=93pCiZT99Ks](https://www.youtube.com/watch?v=93pCiZT99Ks) |
| 🎥 Vidéo — Composer from scratch | [youtube.com/watch?v=zfU_XRQ0Pkg](https://www.youtube.com/watch?v=zfU_XRQ0Pkg) |

> 📌 **Focus sur :** les sections *Autoloading* et *PSR-4* de la doc officielle.

---

### ⚙️ Configuration `composer.json`

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/"
    }
  }
}
```

### ▶️ Commande à exécuter après chaque modification

```bash
composer dump-autoload
```

### 🔍 Comparaison — Avant / Après

```php
// ❌ Sans Composer — require_once manuel à chaque fichier
require_once '../Models/Game.php';
require_once '../Models/Reservation.php';

// ✅ Avec Composer — une seule ligne, peu importe l'emplacement
use App\Models\Game;
use App\Models\Reservation;
```

### 💡 Règle de mapping PSR-4

```
Namespace                →   Chemin du fichier
─────────────────────────────────────────────────
App\Models\Game          →   app/Models/Game.php
App\Controllers\GameController  →  app/Controllers/GameController.php
App\Core\Router          →   app/Core/Router.php
```

---

## 2️⃣ Namespaces — Organisation PSR-4

### 🎯 Objectif
- Organiser le code en modules logiques
- Éviter les conflits de noms entre classes
- Permettre à Composer de localiser chaque classe automatiquement

### 📖 Ressources

| Type | Lien |
|---|---|
| 📄 Documentation PHP | [php.net — Namespaces](https://www.php.net/manual/en/language.namespaces.php) |
| 🎥 Vidéo — PHP Namespaces explained | [youtube.com/watch?v=Xqpml_gVqfk](https://www.youtube.com/watch?v=Xqpml_gVqfk) |

---

### 🧪 Exemples dans le projet

**Model** — `app/Models/Game.php`
```php
<?php

namespace App\Models;

class Game {
    public static function all(): array {
        // SELECT * FROM games
        return [];
    }

    public static function find(int $id): ?array {
        // SELECT * FROM games WHERE id = ?
        return null;
    }
}
```

**Controller** — `app/Controllers/GameController.php`
```php
<?php

namespace App\Controllers;

use App\Models\Game;

class GameController {
    public function index(): void {
        $games = Game::all();
        // passer $games à la vue
    }

    public function show(int $id): void {
        $game = Game::find($id);
        // passer $game à la vue
    }
}
```

### 💡 À retenir

```
Namespace = adresse postale de la classe

App\Models\Game
│    │      └── Nom de la classe  →  Game.php
│    └── Sous-dossier            →  Models/
└── Racine définie dans composer.json  →  app/
```

---

## 3️⃣ Router — Cœur du MVC

### 🎯 Objectif
- Toutes les requêtes HTTP passent par `public/index.php`
- Le Router lit l'URL et la méthode HTTP, puis appelle le bon Controller
- Zéro accès direct aux fichiers PHP

### 📖 Ressources

| Type | Lien |
|---|---|
| 🎥 Tutoriel — Grafikart Router PHP | [grafikart.fr/tutoriels/router-628](https://grafikart.fr/tutoriels/router-628) |
| 🎥 Vidéo — Build a PHP Router from scratch | [youtube.com/watch?v=JycBuHA-glg](https://www.youtube.com/watch?v=JycBuHA-glg) |

---

### 🧪 Définition des routes — `public/index.php`

```php
<?php

require_once '../vendor/autoload.php';

use App\Core\Router;

$router = new Router();

// Module Jeux
$router->get('/games',            'GameController@index');
$router->get('/games/{id}',       'GameController@show');
$router->get('/games/create',     'GameController@create');
$router->post('/games',           'GameController@store');

// Module Réservations
$router->get('/reservations/create',  'ReservationController@create');
$router->post('/reservations',        'ReservationController@store');

// Module Sessions
$router->get('/sessions/dashboard',   'SessionController@dashboard');

$router->dispatch();
```

### 🔁 Flux d'une requête — `GET /games/5`

```
 Browser          index.php        Router            Controller         Model          View
    │                 │               │                   │               │              │
    │  GET /games/5   │               │                   │               │              │
    │────────────────▶│               │                   │               │              │
    │                 │  parse URL    │                   │               │              │
    │                 │──────────────▶│                   │               │              │
    │                 │               │  GameController   │               │              │
    │                 │               │  ::show(5)        │               │              │
    │                 │               │──────────────────▶│               │              │
    │                 │               │                   │  Game::find(5)│              │
    │                 │               │                   │──────────────▶│              │
    │                 │               │                   │   $game data  │              │
    │                 │               │                   │◀──────────────│              │
    │                 │               │                   │               │  render view │
    │                 │               │                   │──────────────────────────────▶│
    │                 HTML response   │                   │               │              │
    │◀────────────────────────────────────────────────────────────────────────────────────│
```

### 💡 Règles des routes dans ce projet

```
Méthode   URL                        Controller::Method
──────────────────────────────────────────────────────────
GET       /games                  →  GameController::index()
GET       /games/{id}             →  GameController::show($id)
POST      /games                  →  GameController::store()
POST      /games/{id}/update      →  GameController::update($id)
GET       /reservations/create    →  ReservationController::create()
POST      /reservations           →  ReservationController::store()
GET       /sessions/dashboard     →  SessionController::dashboard()
POST      /sessions/{id}/end      →  SessionController::end($id)
```

---

## 🔗 Les 3 concepts ensemble

```
composer.json          Namespaces              Router
──────────────         ──────────────          ──────────────
"App\\" : "app/"   +   namespace App\Models;  +  $router->get('/games', ...)
                   =
     Composer sait où trouver chaque classe que le Router demande au Controller
```

**En pratique, l'ordre de mise en place :**

1. Configurer `composer.json` → lancer `composer dump-autoload`
2. Déclarer les namespaces dans chaque fichier PHP
3. Définir les routes dans `index.php`
4. Tester : `GET /games` → doit appeler `GameController::index()` sans erreur

---

*Référence interne — Projet Aji L3bo Café · DigitalBite Agency · Avril 2026*