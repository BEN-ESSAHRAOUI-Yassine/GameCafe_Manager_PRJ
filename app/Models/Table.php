<?php

namespace App\Models;

use Core\Database;
use PDO;

class Table
{
    private $connection;
    private $table = "tables";

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->connect();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllWithAvailability(): array
    {
        $pdo = Database::connect();
        $stmt = $pdo->query('SELECT * FROM tables ORDER BY id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}