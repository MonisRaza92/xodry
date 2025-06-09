<?php

namespace App\Models;
use Core\Database;
use PDO;
use PDOException;

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
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function showAllPickupsByUserId($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pickups WHERE user_id = ?");
        $stmt->execute([$user_id]);
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
}