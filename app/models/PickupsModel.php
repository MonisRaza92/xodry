<?php

namespace App\Models;
use Core\Database;
use PDO;
use PDOException;


class PickupsModel {
    private $db;

    public function __construct() {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }

    public function pickups($user_id, $name, $schedule, $number, $address) {
        try {
            $stmt = $this->db->prepare("INSERT INTO pickups (user_id, name, schedule, number, address) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $name, $schedule, $number, $address]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Update pickup details
    public function updatePickup($user_id, $name, $schedule, $number, $address) {
        try {
            $stmt = $this->db->prepare("UPDATE pickups SET name = ?, schedule = ?, number = ?, address = ? WHERE user_id = ?");
            $stmt->execute([$user_id, $name, $schedule, $number, $address,]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Cancel (delete) a pickup
    public function cancelPickup($user_id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM pickups WHERE user_id = ?");
            $stmt->execute([$user_id]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}