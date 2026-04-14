<?php

namespace Core;

use PDO;
use PDOException;

require_once __DIR__ . '/../app/Config/database.php';

class Database {
    private static ?PDO $instance = null;

    public static function connect(): PDO {
        if (self::$instance === null) {
            $charset = 'utf8mb4';

            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=$charset";

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
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