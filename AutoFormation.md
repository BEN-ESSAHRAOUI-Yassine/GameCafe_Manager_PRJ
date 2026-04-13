#   📚 Learning Resources: Composer, Namespaces & Router
## 🧠 Overview

To successfully build the project, you need to understand:

-   Composer (autoloading)
-   Namespaces (code organization)
-   Router (URL handling)

##  1️⃣ Composer (PSR-4 Autoloading)

### 🎯 Goal
Remove require_once
Automatically load classes
### 📖 Official Documentation
-   Composer
https://getcomposer.org/doc/
["PHP Composer Autoload PSR-4 explained"](https://www.youtube.com/watch?v=93pCiZT99Ks)

https://www.youtube.com/watch?v=zfU_XRQ0Pkg


-   Focus on:

Autoloading
PSR-4

### 🧪 Example

-   ❌ Without Composer
require_once 'Game.php';
-   ✅ With Composer
use App\Models\Game;

-   ⚙️ composer.json
```bash
{
  "autoload": {
    "psr-4": {
      "App\\": "app/"
    }
  }
}
```
-   ▶️ Command
```bash
composer dump-autoload
```
### 💡 How it works
```bash
App\Models\Game → app/Models/Game.php
```
##  2️⃣ Namespaces (PSR-4)
### 🎯 Goal
Organize code
Avoid class conflicts
### 📖 Documentation
PHP
https://www.php.net/manual/en/language.namespaces.php
["PHP Namespaces explained"](https://www.youtube.com/watch?v=Xqpml_gVqfk)
-   Game Model
```bash
namespace App\Models;

class Game {
    public static function all() {
        return [];
    }
}
```
-   Controller
```bash
namespace App\Controllers;

use App\Models\Game;

class GameController {
    public function index() {
        $games = Game::all();
    }
}
```
### 💡 Concept

Namespace = class address

App\Models\Game

##  3️⃣ Router (Core of MVC)
### 🎯 Goal
Handle URLs
Route requests to controllers
### 🧪 Example
-   Route definition
```bash
$router->get('/games', 'GameController@index');
```
-   URL
```bash
/games
```
-   Result
GameController → index()
### 🔁 Flow
User → index.php → Router → Controller → Model → View
### 🎥 Recommended Learning

-   Search on YouTube:
https://grafikart.fr/tutoriels/router-628

["Build a PHP Router from scratch"](https://www.youtube.com/watch?v=JycBuHA-glg)