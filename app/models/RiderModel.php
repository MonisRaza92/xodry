<?php

namespace App\Models;
use Core\Database;
use PDO;
use PDOException;
use App\Constants\PickupStatus;


class RiderModel
{
    private $db;

    public function __construct()
    {
        
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }
    public function getRiderPickupStats($rider_id)
    {
        // Total completed orders (Dropped at Store + Delivered)
        $stmt = $this->db->prepare("SELECT COUNT(*) as pickups FROM pickups WHERE rider_id = :rider_id AND status IN ('Assigned For Pickup',
            'Pickup Pending',
            'Going for Pickup',
            'Picked Up',
            'Dropped at Store')");
        $stmt->execute(['rider_id' => $rider_id]);
        $pickups = $stmt->fetch()['pickups'];

        // Total pending/assigned orders (not completed)
        $stmt = $this->db->prepare("SELECT COUNT(*) as delivery FROM pickups WHERE rider_id = :rider_id AND status NOT IN ('Assigned For Delivery',
            'Out For Delivery',
            'Delivered')");
        $stmt->execute(['rider_id' => $rider_id]);
        $delivery = $stmt->fetch()['delivery'];

        // Total orders today (all status)
        // Total cancelled orders
        $stmt = $this->db->prepare("SELECT COUNT(*) as cancelled FROM pickups WHERE rider_id = :rider_id AND status = 'Cancelled'");
        $stmt->execute(['rider_id' => $rider_id]);
        $cancelled = $stmt->fetch()['cancelled'];

        return [
            'pickups' => $pickups,
            'delivery' => $delivery,
            'cancelled' => $cancelled
        ];
    }
    public function getPickupsByRider($rider_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pickups WHERE rider_id = :rider_id AND status NOT IN ('Dropped at Store', 'Delivered', 'Cancelled') ORDER BY schedule ASC");
        $stmt->execute(['rider_id' => $rider_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUserByPickupId($pickupId)
    {
        $stmt = $this->db->prepare("SELECT user_id FROM pickups WHERE id = ?");
        $stmt->execute([$pickupId]);
        return $stmt->fetchColumn();
    }
    public function getCurrentStatus($pickupId)
    {
        $stmt = $this->db->prepare("SELECT status FROM pickups WHERE id = ?");
        $stmt->execute([$pickupId]);
        return $stmt->fetchColumn();
    }
    public function updateStatusByRider($pickupId, $newStatus)
    {
        $stmt = $this->db->prepare("UPDATE pickups SET status = ? WHERE id = ?");
        return $stmt->execute([$newStatus, $pickupId]);
    }
    public function insertPickupLog($pickupId, $riderId, $stage, $status)
    {
        $stmt = $this->db->prepare("INSERT INTO pickup_logs (pickup_id, rider_id, stage, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pickupId, $riderId, $stage, $status]);
    }

    public function getCompletedPickupsByRider($rider_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pickups WHERE rider_id = :rider_id AND (status = 'Dropped at Store' OR status = 'Delivered')");
        $stmt->execute(['rider_id' => $rider_id]);
        return $stmt->fetchAll();
    }
    public function getRiderHistory($riderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM pickup_logs 
                                    WHERE rider_id = ? 
                                    AND status IN ('Dropped at Store', 'Delivered', 'Cancelled')
                                    ORDER BY timestamp DESC");
        $stmt->execute([$riderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get services by category
    public function getServicesByCategory($categoryId)
    {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert Pickup Items
    public function insertPickupItem($pickupId, $categoryId, $serviceId, $quantity)
    {
        $stmt = $this->db->prepare("INSERT INTO pickup_items (pickup_id, category_id, service_id, quantity) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$pickupId, $categoryId, $serviceId, $quantity]);
    }

    // Get Categories
    public function getAllCategories()
    {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllServices()
    {
        $smtp = $this->db->query("SELECT * FROM services");
        return $smtp->fetchAll(PDO::FETCH_ASSOC);
    }
    public function savePickupDetails($pickupId, $clothCount, $services)
    {
        // 1. pickup_details table me insert
        $stmt = $this->db->prepare("INSERT INTO pickup_details (pickup_id, cloth_count) VALUES (?, ?)");
        $stmt->execute([$pickupId, $clothCount]);

        // inserted pickup_detail_id chahiye
        $pickupDetailId = $this->db->lastInsertId();

        // 2. services bhi insert karo — multiple services
        foreach ($services as $serviceId) {
            $stmt = $this->db->prepare("INSERT INTO pickup_detail_services (pickup_detail_id, service_id) VALUES (?, ?)");
            $stmt->execute([$pickupDetailId, $serviceId]);
        }
    }
}