# 🗂️ Task Breakdown — Aji L3bo Café
> **Ilyas (Dev A) · Abdelatif (Dev B) · Yassin (Dev C)**  
> 5 jours · Lundi 13/04 → Vendredi 17/04/2026

---

## 📌 Règles de collaboration

- Chaque tâche est **indépendante** : tu peux la commencer sans attendre les autres (sauf dépendances explicites)
- Chaque tâche a un **livrable précis** : une PR ne merge que si le livrable est présent
- Les tâches de **Phase 0** (fondations) se font **en parallèle le Jour 1 matin**
- Une fois les 3 tâches de Phase 0 mergées, chacun passe à ses tâches de Phase 1

---

## 🗓️ Vue d'ensemble

| ID | Assigné | Titre | Phase | Dépend de |
|---|---|---|---|---|
| T-01 | **Ilyas** | Générer toutes les vues statiques HTML | Phase 0 | — |
| T-02 | **Abdelatif** | Schéma SQL + seed + classe Database | Phase 0 | — |
| T-03 | **Yassin** | Structure fichiers + Composer + Router + Jira | Phase 0 | — |
| T-04 | **Ilyas** | Model Game + GameController (lecture) | Phase 1 | T-02, T-03 |
| T-05 | **Abdelatif** | Model Reservation + ReservationController (création) | Phase 1 | T-02, T-03 |
| T-06 | **Yassin** | Model User + AuthController (register/login/logout) | Phase 1 | T-02, T-03 |
| T-07 | **Ilyas** | GameController — CRUD Admin (create/edit/delete) | Phase 2 | T-04 |
| T-08 | **Abdelatif** | Disponibilité tables + "Mes Réservations" | Phase 2 | T-05, T-06 |
| T-09 | **Yassin** | Model Session + SessionController (dashboard + start) | Phase 2 | T-05, T-06 |
| T-10 | **Ilyas** | Filtre catégories + validation formulaire jeux | Phase 3 | T-07 |
| T-11 | **Abdelatif** | Admin réservations (liste + confirmer/annuler) | Phase 3 | T-08 |
| T-12 | **Yassin** | SessionController (end session + historique) + Auth Guard | Phase 3 | T-09 |

---

## 🟥 PHASE 0 — Fondations *(Jour 1 matin — tout en parallèle)*

---

### T-01 · Ilyas — Générer toutes les vues statiques HTML

**Objectif :** Produire tous les fichiers de vue en HTML statique (sans PHP, sans données dynamiques). Ces fichiers seront ensuite branchés aux controllers par chacun.

**Fichiers à créer dans `app/Views/` :**

```
auth/
  login.php          → Formulaire : email + password + bouton "Se connecter"
  register.php       → Formulaire : name + email + phone + password + confirm_password

games/
  index.php          → Grille de cartes de jeux (nom, catégorie, joueurs, durée, statut badge)
                       Boutons filtre par catégorie en haut (Stratégie · Ambiance · Famille · Experts)
                       Bouton "Ajouter un jeu" visible (sera masqué côté PHP plus tard)
  show.php           → Détail d'un jeu : tous les champs + badge statut + boutons Modifier/Supprimer
  create.php         → Formulaire : name + category (select) + description + difficulty (1-5) +
                       min_players + max_players + duration_minutes + bouton Submit
  edit.php           → Même formulaire que create.php avec champs pré-remplis (valeurs en dur pour l'instant)

reservations/
  create.php         → Formulaire : party_size + date + heure (select) + duration_hours (select 1h/2h/3h/4h)
                       Section "Tables disponibles" (vide pour l'instant, sera peuplée dynamiquement)
                       Bouton "Vérifier la disponibilité"
  my-reservations.php → Tableau : date, heure, durée, table, party_size, statut coloré
  index.php          → Tableau admin : user name, table, date, heure, durée, party_size, statut
                       Boutons Confirmer / Annuler par ligne

sessions/
  dashboard.php      → Grille des tables : chaque carte = table name + statut (libre / occupée)
                       Si occupée : game name + client name + started_at + durée réservée + temps écoulé
                       Bouton "Démarrer" sur les libres, "Terminer" sur les occupées
  create.php         → Formulaire : select réservation confirmée + select jeu disponible + submit
  history.php        → Tableau : client, jeu, table, started_at, ended_at, durée calculée

layouts/
  header.php         → Nav : logo + liens (Jeux / Réservations / Dashboard) + lien Login/Logout
  footer.php         → Footer simple
```

**Instructions :**
- Utilise de l'HTML valide avec des classes CSS (Bootstrap CDN ou Tailwind CDN, au choix)
- Les données sont en **dur** (hardcodé) : ex. `<td>Catan</td>`, `<td>Stratégie</td>`
- Aucune balise PHP dans ces fichiers pour l'instant
- Commit séparé par groupe de vues : `Add auth views`, `Add games views`, `Add reservations views`, `Add sessions views`

**Livrable :** Tous les fichiers `.php` dans `app/Views/` avec du HTML statique fonctionnel et visuellement lisible.

---

### T-02 · Abdelatif — Schéma SQL + Seed + Classe Database

**Objectif :** Créer la base de données complète et la classe de connexion PDO utilisée par tous les Models.

---

**Fichier 1 : `database/schema.sql`**

Créer les 5 tables dans cet ordre (respecter les FK) :

```sql
-- 1. users
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  phone VARCHAR(20),
  password VARCHAR(255) NOT NULL,
  role ENUM('client', 'admin') NOT NULL DEFAULT 'client',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. tables
CREATE TABLE tables (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  capacity TINYINT NOT NULL,
  status ENUM('available', 'occupied') NOT NULL DEFAULT 'available'
);

-- 3. games
CREATE TABLE games (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  category ENUM('Stratégie', 'Ambiance', 'Famille', 'Experts') NOT NULL,
  description TEXT,
  difficulty TINYINT NOT NULL CHECK (difficulty BETWEEN 1 AND 5),
  min_players TINYINT NOT NULL,
  max_players TINYINT NOT NULL,
  duration_minutes INT NOT NULL,
  status ENUM('available', 'in_use') NOT NULL DEFAULT 'available',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. reservations
CREATE TABLE reservations (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  table_id INT NOT NULL,
  party_size TINYINT NOT NULL,
  reserved_at DATETIME NOT NULL,
  duration_hours TINYINT NOT NULL,
  status ENUM('pending', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (table_id) REFERENCES tables(id)
);

-- 5. sessions
CREATE TABLE sessions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  reservation_id INT NOT NULL,
  game_id INT NOT NULL,
  table_id INT NOT NULL,
  started_at DATETIME NOT NULL,
  ended_at DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (reservation_id) REFERENCES reservations(id),
  FOREIGN KEY (game_id) REFERENCES games(id),
  FOREIGN KEY (table_id) REFERENCES tables(id)
);
```

---

**Fichier 2 : `database/seed.sql`**

Insérer exactement :
- **3 users** : 1 admin (`role='admin'`), 2 clients (`role='client'`) — passwords hashés avec `password_hash('password123', PASSWORD_BCRYPT)`, noter le hash en dur dans le SQL
- **4 tables** : Table 1 (cap. 4), Table 2 (cap. 4), Table 3 (cap. 6), Table 4 (cap. 8)
- **15 jeux** : au moins 3 par catégorie (Stratégie, Ambiance, Famille, Experts), durées et difficultés variées
- **5 réservations** : statuts variés (`pending` x2, `confirmed` x2, `completed` x1), `duration_hours` variées (1, 2, 3)
- **2 sessions actives** : `started_at` = maintenant, `ended_at` = NULL, liées aux réservations `confirmed`

---

**Fichier 3 : `core/Database.php`**

```php
<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function connect(): PDO {
        if (self::$instance === null) {
            $host = 'localhost';
            $db   = 'aji_l3bo';
            $user = 'root';
            $pass = '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die('Connexion échouée : ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
```

**Livrable :** `database/schema.sql` + `database/seed.sql` (données complètes) + `core/Database.php` fonctionnel.

---

### T-03 · Yassin — Structure fichiers + Composer + Router + Jira

**Objectif :** Mettre en place le squelette complet du projet, le routing, et le board Jira.

---

**Étape 1 — Créer l'arborescence complète des fichiers**

```bash
mkdir -p app/Controllers app/Models app/Views/auth app/Views/games \
         app/Views/reservations app/Views/sessions app/Views/layouts \
         core public database
touch public/index.php public/.htaccess
touch core/Router.php core/Database.php core/Controller.php
touch app/Controllers/GameController.php
touch app/Controllers/ReservationController.php
touch app/Controllers/SessionController.php
touch app/Controllers/AuthController.php
touch app/Models/Game.php app/Models/Reservation.php
touch app/Models/Session.php app/Models/Table.php app/Models/User.php
touch composer.json .gitignore README.md
```

---

**Étape 2 — `composer.json`**

```json
{
  "name": "aji-l3bo/cafe",
  "description": "Système de gestion Aji L3bo Café",
  "type": "project",
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "App\\Core\\": "core/"
    }
  },
  "require": {}
}
```

Lancer : `composer dump-autoload`

---

**Étape 3 — `public/.htaccess`**

```apache
Options -MultiViews
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
```

---

**Étape 4 — `core/Router.php`**

Implémenter la classe Router avec :
- `get(string $uri, string $action): void` — enregistre une route GET
- `post(string $uri, string $action): void` — enregistre une route POST
- `dispatch(): void` — lit `$_SERVER['REQUEST_URI']` et `$_SERVER['REQUEST_METHOD']`, trouve la route correspondante, extrait les paramètres dynamiques (`{id}`), instancie le controller et appelle la méthode

```php
<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $uri, string $action): void {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, string $action): void {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes[$method] ?? [] as $route => $action) {
            // Convertir {id} en regex (\d+)
            $pattern = preg_replace('/\{[a-z]+\}/', '(\d+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // retirer le full match
                [$controllerName, $methodName] = explode('@', $action);
                $class = "App\\Controllers\\$controllerName";
                $controller = new $class();
                $controller->$methodName(...$matches);
                return;
            }
        }

        http_response_code(404);
        echo '<h1>404 — Page introuvable</h1>';
    }
}
```

---

**Étape 5 — `public/index.php`**

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

session_start();

$router = new Router();

// Auth
$router->get('/login',    'AuthController@loginForm');
$router->post('/login',   'AuthController@login');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register','AuthController@register');
$router->post('/logout',  'AuthController@logout');

// Games
$router->get('/games',              'GameController@index');
$router->get('/games/create',       'GameController@create');
$router->post('/games',             'GameController@store');
$router->get('/games/{id}',         'GameController@show');
$router->get('/games/{id}/edit',    'GameController@edit');
$router->post('/games/{id}/update', 'GameController@update');
$router->post('/games/{id}/delete', 'GameController@destroy');

// Reservations
$router->get('/reservations',              'ReservationController@index');
$router->get('/reservations/create',       'ReservationController@create');
$router->post('/reservations',             'ReservationController@store');
$router->get('/reservations/my',           'ReservationController@mine');
$router->post('/reservations/{id}/status', 'ReservationController@updateStatus');

// Sessions
$router->get('/sessions/dashboard',  'SessionController@dashboard');
$router->get('/sessions/create',     'SessionController@create');
$router->post('/sessions',           'SessionController@store');
$router->post('/sessions/{id}/end',  'SessionController@end');
$router->get('/sessions/history',    'SessionController@history');

$router->dispatch();
```

---

**Étape 6 — `.gitignore`**

```
/vendor/
.env
*.log
```

---

**Étape 7 — Jira Board**

Créer le board et ajouter **les 12 tickets** (T-01 à T-12) avec :
- **Title** : l'intitulé exact du tableau ci-dessus
- **Assignee** : le dev concerné
- **Status initial** : `To Do`
- **Labels** : `Phase-0`, `Phase-1`, `Phase-2`, `Phase-3`
- **Description** : copier le contenu de chaque tâche depuis ce fichier

Livrer le board avant **lundi 16:00**.

**Livrable :** Arborescence créée, `composer.json` fonctionnel, `Router.php` opérationnel, `index.php` avec toutes les routes, Jira board avec 12 tickets.

---

## 🟧 PHASE 1 — Modules Core *(Jour 1 après-midi → Jour 2)*
> Démarrer uniquement quand T-01 + T-02 + T-03 sont mergés.

---

### T-04 · Ilyas — Model Game + GameController (lecture)

**Objectif :** Brancher les vues statiques des jeux à de vraies données depuis la BDD.

---

**Fichier : `app/Models/Game.php`**

```php
<?php

namespace App\Models;

use App\Core\Database;

class Game {
    public static function all(): array {
        $pdo = Database::connect();
        $stmt = $pdo->query('SELECT * FROM games ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): array|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM games WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function allByCategory(string $category): array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM games WHERE category = ? ORDER BY name ASC');
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }
}
```

---

**Fichier : `app/Controllers/GameController.php`**

Implémenter les méthodes `index()` et `show(int $id)` :

```php
<?php

namespace App\Controllers;

use App\Models\Game;

class GameController {

    // GET /games
    public function index(): void {
        $games = Game::all();
        require __DIR__ . '/../Views/games/index.php';
    }

    // GET /games/{id}
    public function show(int $id): void {
        $game = Game::find($id);
        if (!$game) {
            http_response_code(404);
            echo '<h1>Jeu introuvable</h1>';
            return;
        }
        require __DIR__ . '/../Views/games/show.php';
    }
}
```

---

**Mettre à jour `app/Views/games/index.php`**

Remplacer les données hardcodées par une boucle PHP :

```php
<?php foreach ($games as $game): ?>
  <div class="card">
    <h3><?= htmlspecialchars($game['name']) ?></h3>
    <span><?= $game['category'] ?></span>
    <span><?= $game['min_players'] ?>–<?= $game['max_players'] ?> joueurs</span>
    <span><?= $game['duration_minutes'] ?> min</span>
    <span class="badge"><?= $game['status'] === 'available' ? '✅ Disponible' : '🔴 En cours' ?></span>
    <a href="/games/<?= $game['id'] ?>">Voir les détails</a>
  </div>
<?php endforeach; ?>
```

**Mettre à jour `app/Views/games/show.php`** de la même façon avec `$game['...']`.

**Livrable :** `GET /games` affiche les 15 jeux depuis la BDD · `GET /games/3` affiche le détail du jeu #3 · 404 si id inexistant.

---

### T-05 · Abdelatif — Model Reservation + ReservationController (création)

**Objectif :** Permettre à un utilisateur connecté de soumettre une réservation.

---

**Fichier : `app/Models/Reservation.php`**

```php
<?php

namespace App\Models;

use App\Core\Database;

class Reservation {

    public static function create(array $data): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('
            INSERT INTO reservations (user_id, table_id, party_size, reserved_at, duration_hours, status)
            VALUES (?, ?, ?, ?, ?, "pending")
        ');
        return $stmt->execute([
            $data['user_id'],
            $data['table_id'],
            $data['party_size'],
            $data['reserved_at'],
            $data['duration_hours'],
        ]);
    }

    public static function findByUser(int $userId): array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('
            SELECT r.*, t.name AS table_name
            FROM reservations r
            JOIN tables t ON r.table_id = t.id
            WHERE r.user_id = ?
            ORDER BY r.reserved_at DESC
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
```

---

**Fichier : `app/Controllers/ReservationController.php`**

Implémenter `create()` et `store()` :

```php
<?php

namespace App\Controllers;

use App\Models\Reservation;

class ReservationController {

    // GET /reservations/create
    public function create(): void {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        require __DIR__ . '/../Views/reservations/create.php';
    }

    // POST /reservations
    public function store(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Validation
        $errors = [];
        if (empty($_POST['party_size']) || $_POST['party_size'] < 1) {
            $errors[] = 'Nombre de personnes invalide.';
        }
        if (empty($_POST['reserved_at'])) {
            $errors[] = 'Date et heure obligatoires.';
        }
        if (empty($_POST['duration_hours']) || !in_array($_POST['duration_hours'], [1, 2, 3, 4])) {
            $errors[] = 'Durée invalide.';
        }
        if (empty($_POST['table_id'])) {
            $errors[] = 'Veuillez sélectionner une table.';
        }

        if (!empty($errors)) {
            require __DIR__ . '/../Views/reservations/create.php';
            return;
        }

        Reservation::create([
            'user_id'       => $_SESSION['user_id'],
            'table_id'      => (int) $_POST['table_id'],
            'party_size'    => (int) $_POST['party_size'],
            'reserved_at'   => $_POST['reserved_at'],
            'duration_hours'=> (int) $_POST['duration_hours'],
        ]);

        header('Location: /reservations/my');
        exit;
    }
}
```

**Livrable :** `GET /reservations/create` affiche le formulaire · `POST /reservations` insère en BDD et redirige vers `/reservations/my` · validation des champs obligatoires.

---

### T-06 · Yassin — Model User + AuthController (register/login/logout)

**Objectif :** Système d'authentification complet avec session PHP.

---

**Fichier : `app/Models/User.php`**

```php
<?php

namespace App\Models;

use App\Core\Database;

class User {

    public static function findByEmail(string $email): array|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function create(array $data): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('
            INSERT INTO users (name, email, phone, password, role)
            VALUES (?, ?, ?, ?, "client")
        ');
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            password_hash($data['password'], PASSWORD_BCRYPT),
        ]);
    }

    public static function find(int $id): array|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
```

---

**Fichier : `app/Controllers/AuthController.php`**

```php
<?php

namespace App\Controllers;

use App\Models\User;

class AuthController {

    // GET /login
    public function loginForm(): void {
        require __DIR__ . '/../Views/auth/login.php';
    }

    // POST /login
    public function login(): void {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors   = [];

        if (empty($email) || empty($password)) {
            $errors[] = 'Email et mot de passe obligatoires.';
        }

        if (empty($errors)) {
            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role']    = $user['role'];
                $_SESSION['name']    = $user['name'];

                // Redirection selon le rôle
                header($user['role'] === 'admin'
                    ? 'Location: /sessions/dashboard'
                    : 'Location: /games');
                exit;
            }
            $errors[] = 'Email ou mot de passe incorrect.';
        }

        require __DIR__ . '/../Views/auth/login.php';
    }

    // GET /register
    public function registerForm(): void {
        require __DIR__ . '/../Views/auth/register.php';
    }

    // POST /register
    public function register(): void {
        $errors = [];

        if (empty($_POST['name']))     $errors[] = 'Nom obligatoire.';
        if (empty($_POST['email']))    $errors[] = 'Email obligatoire.';
        if (empty($_POST['password'])) $errors[] = 'Mot de passe obligatoire.';
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
        if (strlen($_POST['password'] ?? '') < 8) {
            $errors[] = 'Mot de passe minimum 8 caractères.';
        }

        if (User::findByEmail($_POST['email'] ?? '')) {
            $errors[] = 'Cet email est déjà utilisé.';
        }

        if (!empty($errors)) {
            require __DIR__ . '/../Views/auth/register.php';
            return;
        }

        User::create([
            'name'     => trim($_POST['name']),
            'email'    => trim($_POST['email']),
            'phone'    => trim($_POST['phone'] ?? ''),
            'password' => $_POST['password'],
        ]);

        header('Location: /login');
        exit;
    }

    // POST /logout
    public function logout(): void {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
```

**Mettre à jour les vues** `auth/login.php` et `auth/register.php` pour afficher `$errors` si défini.

**Livrable :** `POST /login` crée la session et redirige selon le rôle · `POST /register` crée un user `client` · `POST /logout` détruit la session · erreurs affichées dans les vues.

---

## 🟨 PHASE 2 — Fonctionnalités avancées *(Jour 3)*

---

### T-07 · Ilyas — GameController CRUD Admin (create/edit/delete)

**Objectif :** Permettre à l'admin d'ajouter, modifier et supprimer des jeux.

**Prérequis :** T-04 mergé.

---

**Ajouter à `app/Models/Game.php` :**

```php
public static function insert(array $data): bool {
    $pdo = Database::connect();
    $stmt = $pdo->prepare('
        INSERT INTO games (name, category, description, difficulty, min_players, max_players, duration_minutes)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ');
    return $stmt->execute([
        $data['name'], $data['category'], $data['description'],
        $data['difficulty'], $data['min_players'], $data['max_players'], $data['duration_minutes']
    ]);
}

public static function update(int $id, array $data): bool {
    $pdo = Database::connect();
    $stmt = $pdo->prepare('
        UPDATE games SET name=?, category=?, description=?, difficulty=?,
        min_players=?, max_players=?, duration_minutes=? WHERE id=?
    ');
    return $stmt->execute([
        $data['name'], $data['category'], $data['description'],
        $data['difficulty'], $data['min_players'], $data['max_players'],
        $data['duration_minutes'], $id
    ]);
}

public static function delete(int $id): bool {
    $pdo = Database::connect();
    $stmt = $pdo->prepare('DELETE FROM games WHERE id = ?');
    return $stmt->execute([$id]);
}
```

---

**Ajouter à `app/Controllers/GameController.php` :**

- `create()` → vérifier `$_SESSION['role'] === 'admin'`, puis afficher `Views/games/create.php`
- `store()` → valider les champs (name, category, difficulty 1–5, min/max players > 0), appeler `Game::insert()`, rediriger vers `/games`
- `edit(int $id)` → récupérer `Game::find($id)`, passer à `Views/games/edit.php`
- `update(int $id)` → mêmes validations que `store()`, appeler `Game::update($id, ...)`, rediriger vers `/games/{id}`
- `destroy(int $id)` → vérifier admin, appeler `Game::delete($id)`, rediriger vers `/games`

**Ajouter dans chaque méthode admin :**
```php
if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo '<h1>Accès interdit</h1>';
    return;
}
```

**Mettre à jour les vues** `games/create.php` et `games/edit.php` pour afficher `$errors` et pré-remplir les champs dans `edit.php` avec `$game['...']`.

**Livrable :** Admin peut créer/modifier/supprimer un jeu · accès refusé (403) si non-admin · validation serveur fonctionnelle.

---

### T-08 · Abdelatif — Disponibilité des tables + "Mes Réservations"

**Objectif :** Calculer les tables libres pour un créneau donné et afficher les réservations d'un client.

**Prérequis :** T-05 mergé.

---

**Ajouter à `app/Models/Reservation.php` :**

```php
// Retourne les tables qui n'ont AUCUNE réservation (pending ou confirmed)
// qui chevauche le créneau [reserved_at, reserved_at + duration_hours]
public static function getAvailableTables(string $reservedAt, int $durationHours): array {
    $pdo = Database::connect();
    $stmt = $pdo->prepare('
        SELECT t.*
        FROM tables t
        WHERE t.id NOT IN (
            SELECT r.table_id
            FROM reservations r
            WHERE r.status IN ("pending", "confirmed")
            AND r.reserved_at < DATE_ADD(?, INTERVAL ? HOUR)
            AND DATE_ADD(r.reserved_at, INTERVAL r.duration_hours HOUR) > ?
        )
    ');
    $stmt->execute([$reservedAt, $durationHours, $reservedAt]);
    return $stmt->fetchAll();
}
```

---

**Ajouter dans `app/Controllers/ReservationController.php` :**

```php
// GET /reservations/my
public function mine(): void {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
    $reservations = Reservation::findByUser($_SESSION['user_id']);
    require __DIR__ . '/../Views/reservations/my-reservations.php';
}
```

---

**Ajouter une route AJAX pour la disponibilité dans `ReservationController` :**

```php
// POST /reservations/available  (appel depuis le formulaire)
public function available(): void {
    header('Content-Type: application/json');
    $reservedAt    = $_POST['reserved_at'] ?? '';
    $durationHours = (int) ($_POST['duration_hours'] ?? 0);

    if (!$reservedAt || !$durationHours) {
        echo json_encode(['error' => 'Paramètres manquants']);
        return;
    }

    $tables = Reservation::getAvailableTables($reservedAt, $durationHours);
    echo json_encode($tables);
}
```

Ajouter la route dans `index.php` :
```php
$router->post('/reservations/available', 'ReservationController@available');
```

**Mettre à jour `Views/reservations/create.php`** : ajouter un petit JS `fetch()` qui appelle `/reservations/available` au clic de "Vérifier la disponibilité" et affiche les tables retournées sous forme de boutons radio.

**Mettre à jour `Views/reservations/my-reservations.php`** : boucler sur `$reservations` avec badge couleur selon `$r['status']`.

**Livrable :** Bouton "Vérifier la disponibilité" retourne les vraies tables libres · `/reservations/my` liste les réservations du client connecté.

---

### T-09 · Yassin — Model Session + SessionController (dashboard + start)

**Objectif :** Permettre à l'admin de voir le dashboard des tables et de démarrer une session.

**Prérequis :** T-05 et T-06 mergés.

---

**Fichier : `app/Models/Session.php`**

```php
<?php

namespace App\Models;

use App\Core\Database;

class Session {

    // Récupère toutes les sessions actives avec JOIN complet
    public static function getActive(): array {
        $pdo = Database::connect();
        $stmt = $pdo->query('
            SELECT s.*, g.name AS game_name, t.name AS table_name,
                   u.name AS client_name, r.duration_hours,
                   TIMESTAMPDIFF(MINUTE, s.started_at, NOW()) AS elapsed_minutes
            FROM sessions s
            JOIN games g        ON s.game_id = g.id
            JOIN tables t       ON s.table_id = t.id
            JOIN reservations r ON s.reservation_id = r.id
            JOIN users u        ON r.user_id = u.id
            WHERE s.ended_at IS NULL
        ');
        return $stmt->fetchAll();
    }

    // Récupère toutes les tables + statut session active si occupée
    public static function getAllTablesWithStatus(): array {
        $pdo = Database::connect();
        $stmt = $pdo->query('
            SELECT t.*,
                   s.id AS session_id, s.started_at,
                   g.name AS game_name,
                   u.name AS client_name,
                   r.duration_hours
            FROM tables t
            LEFT JOIN sessions s ON s.table_id = t.id AND s.ended_at IS NULL
            LEFT JOIN games g    ON s.game_id = g.id
            LEFT JOIN reservations r ON s.reservation_id = r.id
            LEFT JOIN users u    ON r.user_id = u.id
        ');
        return $stmt->fetchAll();
    }

    public static function create(array $data): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('
            INSERT INTO sessions (reservation_id, game_id, table_id, started_at)
            VALUES (?, ?, ?, NOW())
        ');
        return $stmt->execute([
            $data['reservation_id'],
            $data['game_id'],
            $data['table_id'],
        ]);
    }
}
```

---

**Fichier : `app/Controllers/SessionController.php`**

```php
<?php

namespace App\Controllers;

use App\Models\Session;
use App\Models\Game;
use App\Models\Reservation;

class SessionController {

    private function requireAdmin(): void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo '<h1>Accès réservé à l\'admin</h1>';
            exit;
        }
    }

    // GET /sessions/dashboard
    public function dashboard(): void {
        $this->requireAdmin();
        $tables = Session::getAllTablesWithStatus();
        require __DIR__ . '/../Views/sessions/dashboard.php';
    }

    // GET /sessions/create
    public function create(): void {
        $this->requireAdmin();
        // Réservations confirmées sans session active
        $pdo = \App\Core\Database::connect();
        $stmt = $pdo->query('
            SELECT r.*, u.name AS client_name, t.name AS table_name
            FROM reservations r
            JOIN users u  ON r.user_id = u.id
            JOIN tables t ON r.table_id = t.id
            WHERE r.status = "confirmed"
            AND r.id NOT IN (SELECT reservation_id FROM sessions WHERE ended_at IS NULL)
        ');
        $reservations = $stmt->fetchAll();
        $games = Game::allByStatus('available');
        require __DIR__ . '/../Views/sessions/create.php';
    }

    // POST /sessions
    public function store(): void {
        $this->requireAdmin();

        // Démarrer la session
        Session::create([
            'reservation_id' => (int) $_POST['reservation_id'],
            'game_id'        => (int) $_POST['game_id'],
            'table_id'       => (int) $_POST['table_id'],
        ]);

        // Marquer la table comme occupée
        $pdo = \App\Core\Database::connect();
        $pdo->prepare("UPDATE tables SET status = 'occupied' WHERE id = ?")
            ->execute([(int) $_POST['table_id']]);

        // Marquer le jeu comme en cours
        $pdo->prepare("UPDATE games SET status = 'in_use' WHERE id = ?")
            ->execute([(int) $_POST['game_id']]);

        header('Location: /sessions/dashboard');
        exit;
    }
}
```

**Ajouter à `app/Models/Game.php` :**
```php
public static function allByStatus(string $status): array {
    $pdo = Database::connect();
    $stmt = $pdo->prepare('SELECT * FROM games WHERE status = ?');
    $stmt->execute([$status]);
    return $stmt->fetchAll();
}
```

**Mettre à jour `Views/sessions/dashboard.php`** : boucler sur `$tables`, afficher les infos de session si `$table['session_id']` est défini, calculer `elapsed_minutes` vs `duration_hours * 60`.

**Livrable :** Dashboard affiche toutes les tables avec statut réel · formulaire "Démarrer session" fonctionne · table + jeu passent à `occupied`/`in_use` après démarrage.

---

## 🟩 PHASE 3 — Finalisation *(Jour 4–5)*

---

### T-10 · Ilyas — Filtre catégories + validation visuelle jeux

**Objectif :** Filtre fonctionnel sur la liste des jeux, et affichage des erreurs de validation.

**Prérequis :** T-07 mergé.

---

**Mettre à jour `GameController::index()` :**

```php
public function index(): void {
    $category = $_GET['category'] ?? null;
    $validCategories = ['Stratégie', 'Ambiance', 'Famille', 'Experts'];

    if ($category && in_array($category, $validCategories)) {
        $games = Game::allByCategory($category);
    } else {
        $games = Game::all();
        $category = null;
    }

    require __DIR__ . '/../Views/games/index.php';
}
```

**Mettre à jour `Views/games/index.php` :**
- Les boutons de filtre sont des liens `<a href="/games?category=Stratégie">` etc.
- Le bouton actif a une classe CSS différente : `$category === 'Stratégie' ? 'active' : ''`
- Lien "Tous" → `/games` (sans paramètre)

**Mettre à jour `Views/games/create.php` et `edit.php` :**
- Afficher les erreurs `$errors` si le tableau est défini
- Conserver les valeurs saisies (attribut `value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"`)

**Livrable :** Filtre par catégorie fonctionne via URL · erreurs de formulaire affichées avec les valeurs conservées.

---

### T-11 · Abdelatif — Admin réservations (liste + confirmer/annuler)

**Objectif :** L'admin peut voir toutes les réservations et changer leur statut.

**Prérequis :** T-08 mergé.

---

**Ajouter à `app/Models/Reservation.php` :**

```php
public static function all(): array {
    $pdo = Database::connect();
    $stmt = $pdo->query('
        SELECT r.*, u.name AS client_name, u.phone, t.name AS table_name
        FROM reservations r
        JOIN users u  ON r.user_id = u.id
        JOIN tables t ON r.table_id = t.id
        ORDER BY r.reserved_at DESC
    ');
    return $stmt->fetchAll();
}

public static function updateStatus(int $id, string $status): bool {
    $allowed = ['pending', 'confirmed', 'completed', 'cancelled'];
    if (!in_array($status, $allowed)) return false;

    $pdo = Database::connect();
    $stmt = $pdo->prepare('UPDATE reservations SET status = ? WHERE id = ?');
    return $stmt->execute([$status, $id]);
}
```

---

**Ajouter à `app/Controllers/ReservationController.php` :**

```php
// GET /reservations
public function index(): void {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: /login'); exit;
    }
    $reservations = Reservation::all();
    require __DIR__ . '/../Views/reservations/index.php';
}

// POST /reservations/{id}/status
public function updateStatus(int $id): void {
    if ($_SESSION['role'] !== 'admin') {
        http_response_code(403); return;
    }
    $status = $_POST['status'] ?? '';
    Reservation::updateStatus($id, $status);
    header('Location: /reservations');
    exit;
}
```

**Mettre à jour `Views/reservations/index.php`** : boucler sur `$reservations`, afficher les données avec JOIN (client name, table name, date, heure, durée, party_size, statut). Chaque ligne a un formulaire `<form method="POST" action="/reservations/{id}/status">` avec des boutons Confirmer/Annuler.

**Livrable :** `/reservations` liste toutes les réservations avec infos client et table · boutons Confirmer/Annuler changent le statut en BDD.

---

### T-12 · Yassin — End Session + Historique + Auth Guard

**Objectif :** Terminer une session proprement, consulter l'historique, et protéger toutes les routes admin.

**Prérequis :** T-09 mergé.

---

**Ajouter à `app/Models/Session.php` :**

```php
public static function end(int $id): bool {
    $pdo = Database::connect();
    $stmt = $pdo->prepare('UPDATE sessions SET ended_at = NOW() WHERE id = ?');
    return $stmt->execute([$id]);
}

public static function getAll(): array {
    $pdo = Database::connect();
    $stmt = $pdo->query('
        SELECT s.*, g.name AS game_name, t.name AS table_name,
               u.name AS client_name,
               TIMESTAMPDIFF(MINUTE, s.started_at, s.ended_at) AS duration_minutes
        FROM sessions s
        JOIN games g        ON s.game_id = g.id
        JOIN tables t       ON s.table_id = t.id
        JOIN reservations r ON s.reservation_id = r.id
        JOIN users u        ON r.user_id = u.id
        WHERE s.ended_at IS NOT NULL
        ORDER BY s.ended_at DESC
    ');
    return $stmt->fetchAll();
}
```

---

**Ajouter à `app/Controllers/SessionController.php` :**

```php
// POST /sessions/{id}/end
public function end(int $id): void {
    $this->requireAdmin();

    // Récupérer la session pour avoir table_id et game_id
    $pdo = \App\Core\Database::connect();
    $stmt = $pdo->prepare('SELECT * FROM sessions WHERE id = ?');
    $stmt->execute([$id]);
    $session = $stmt->fetch();

    Session::end($id);

    // Libérer la table
    $pdo->prepare("UPDATE tables SET status = 'available' WHERE id = ?")
        ->execute([$session['table_id']]);

    // Remettre le jeu disponible
    $pdo->prepare("UPDATE games SET status = 'available' WHERE id = ?")
        ->execute([$session['game_id']]);

    // Marquer la réservation comme complétée
    $pdo->prepare("UPDATE reservations SET status = 'completed' WHERE id = ?")
        ->execute([$session['reservation_id']]);

    header('Location: /sessions/dashboard');
    exit;
}

// GET /sessions/history
public function history(): void {
    $this->requireAdmin();
    $sessions = Session::getAll();
    require __DIR__ . '/../Views/sessions/history.php';
}
```

---

**Auth Guard — ajouter `core/Auth.php`**

```php
<?php

namespace App\Core;

class Auth {
    public static function requireLogin(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireAdmin(): void {
        self::requireLogin();
        if ($_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo '<h1>403 — Accès interdit</h1>';
            exit;
        }
    }

    public static function user(): array|false {
        if (!isset($_SESSION['user_id'])) return false;
        return User::find($_SESSION['user_id']);
    }

    public static function isAdmin(): bool {
        return ($_SESSION['role'] ?? '') === 'admin';
    }
}
```

Remplacer tous les checks inline `$_SESSION['role'] !== 'admin'` dans les controllers existants par `Auth::requireAdmin()` et `Auth::requireLogin()`.

**Mettre à jour `Views/sessions/history.php`** : boucler sur `$sessions` pour afficher le tableau complet avec durée calculée.

**Livrable :** "Terminer session" libère table + jeu + complète la réservation · `/sessions/history` affiche l'historique · classe `Auth` centralisée utilisable dans tous les controllers.

---

## 📋 Récapitulatif final

| Dev | Tâches | Responsabilités |
|---|---|---|
| **Ilyas** | T-01 · T-04 · T-07 · T-10 | Vues statiques · Module Games complet · Filtre + validation |
| **Abdelatif** | T-02 · T-05 · T-08 · T-11 | BDD + PDO · Reservations création · Disponibilité · Admin reservations |
| **Yassin** | T-03 · T-06 · T-09 · T-12 | Structure + Router · Auth système · Sessions dashboard · End session + Guard |

---

*Projet Aji L3bo Café · DigitalBite Agency · Avril 2026*