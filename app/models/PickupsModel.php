<?php

namespace App\Models;
use Core\Database;
use PDO;
use PDOException;
use App\Constants\PickupStatus;


class PickupsModel {
    private $db;

    public function __construct() {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }

    public function createPickups($user_id, $name, $schedule, $pickup_time, $number, $address) {
        try {
            $stmt = $this->db->prepare("INSERT INTO pickups (user_id, name, schedule, pickup_time, number, address) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $name, $schedule, $pickup_time, $number, $address]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Update pickup details
    public function updatePickup($user_id, $name, $schedule, $pickup_time, $number, $address) {
        try {
            $stmt = $this->db->prepare("UPDATE pickups SET name = ?, schedule = ?, pickup_time = ?, number = ?, address = ? WHERE user_id = ?");
            $stmt->execute([$name, $schedule, $pickup_time, $number, $address, $user_id]);
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

    // Update pickup status
    public function updatePickupStatusCancel($pickup_id) {
        try {
            $stmt = $this->db->prepare("UPDATE pickups SET status = ? WHERE id = ?");
            $stmt->execute([PickupStatus::CANCELLED, $pickup_id]);
            return true;
        } catch (PDOException $e) {
            return "Failed to update pickup status";
        }
    }
    public function updatePickupStatus($pickup_id, $status) {
        try {
            $stmt = $this->db->prepare("UPDATE pickups SET status = ? WHERE id = ?");
            $stmt->execute([$status, $pickup_id]);
            return true;
        } catch (PDOException $e) {
            return "Failed to update pickup status";
        }
    }
    
    public function getPickupByUserId($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM pickups WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPickupsCountByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM pickups WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int) $result['count'] : 0;
    }

    public function getAllPickups() {
        $stmt = $this->db->prepare("SELECT * FROM pickups ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllPickupsStatus() {
        $stmt = $this->db->prepare("SELECT id, status FROM pickups");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function assignRider($pickup_id, $rider_id)
    {
        $stmt = $this->db->prepare("UPDATE pickups SET rider_id = :rider_id WHERE id = :pickup_id");
        return $stmt->execute([
            'rider_id' => $rider_id,
            'pickup_id' => $pickup_id
        ]);
    }
}