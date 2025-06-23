<?php

namespace App\Models;
use Core\Database;
use PDO;
use PDOException;


class PickupItemsModel
{
    private $db;

    public function __construct()
    {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }

    public function savePickupItem($pickupId, $categoryId, $serviceId, $quantity, $totalPrice)
    {
        $stmt = $this->db->prepare("INSERT INTO pickup_items (pickup_id, category_id, service_id, quantity, total_price) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$pickupId, $categoryId, $serviceId, $quantity, $totalPrice]);
    }
    public function getAllPickupItems()
    {
        $stmt = $this->db->query("SELECT * FROM pickup_items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPickupItemsByPickupId($pickupId)
    {
        $stmt = $this->db->prepare("SELECT * FROM pickup_items WHERE pickup_id = ?");
        $stmt->execute([$pickupId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
