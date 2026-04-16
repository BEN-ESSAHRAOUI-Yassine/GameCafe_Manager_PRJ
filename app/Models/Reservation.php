<?php

namespace App\Models;

use Core\Database;
use PDO;

class Reservation
{
    private $connection;
    private $table = "reservations";

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->connect();
    }

    // ✅ Create new reservation
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (user_id, table_id, party_size, reserved_at, duration_hours, status) 
                VALUES 
                (:user_id, :table_id, :party_size, :reserved_at, :duration_hours, :status)";

        $stmt = $this->connection->prepare($sql);

        echo 'this is a table_id' . $data['table_id'];

        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':table_id' => $data['table_id'],
            ':party_size' => $data['party_size'],
            ':reserved_at' => $data['reserved_at'],
            ':duration_hours' => $data['duration_hours'],
            ':status' => $data['status']
        ]);
    }

    // ✅ Get all reservations
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Get reservation by ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Get reservations with user + table
    public function getWithDetails()
    {
        $sql = "SELECT 
                    r.*, 
                    u.name AS user_name,
                    t.name AS table_name
                FROM reservations r
                JOIN users u ON r.user_id = u.id
                JOIN tables t ON r.table_id = t.id
                ORDER BY r.created_at DESC";

        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Update reservation status
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE {$this->table} 
                SET status = :status 
                WHERE id = :id";

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }

    // ✅ Delete reservation
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public static function getAvailableTables(string $reservedAt, int $durationHours): array {
        $pdo  = Database::connect();
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

    public function findByUser($id){
        $sql = "SELECT 
                    r.*, 
                    u.name AS user_name,
                    t.name AS table_name
                FROM reservations r
                JOIN users u ON r.user_id = u.id
                JOIN tables t ON r.table_id = t.id
                WHERE r.user_id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}