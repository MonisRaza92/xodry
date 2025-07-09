<?php

namespace App\Models;
use Core\Database;
use PDO;
use PDOException;
use App\Constants\PickupStatus;

class UserModel{
    private $db;

    public function __construct($db)
    {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }

    public function getUserById($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = ?");
        $stmt->execute(['user']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllUsersWithPickupCount()
    {
        $stmt = $this->db->prepare("
        SELECT u.*, 
               COUNT(p.id) as pickup_count
        FROM users u
        LEFT JOIN pickups p ON u.id = p.user_id
        WHERE u.role = 'user'
        GROUP BY u.id
        ORDER BY u.id DESC
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getAllRiders()
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = ?");
        $stmt->execute(['rider']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function updateUser($id, $name, $number, $email, $address)
    {
         try {
              $stmt = $this->db->prepare("UPDATE users SET name = ?, number = ?, email = ?, address = ? WHERE id = ?");
              $stmt->execute([$name, $number, $email, $address, $id]);
              return $stmt->rowCount() > 0;
         } catch (PDOException $e) {
              return false;
         }
    }

    public function showAllPickupsByUserId($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pickups WHERE user_id = ? AND (status != ? OR status IS NULL)");
        $stmt->execute([$user_id, PickupStatus::CANCELLED]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}