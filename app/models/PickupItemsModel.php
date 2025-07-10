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

    public function savePickupItemWithComment($pickupId, $categoryId, $serviceId, $quantity, $totalPrice, $comment = '')
    {
        $stmt = $this->db->prepare("INSERT INTO pickup_items (pickup_id, category_id, service_id, quantity, total_price, comment) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$pickupId, $categoryId, $serviceId, $quantity, $totalPrice, $comment]);
    }

    public function saveTotalPrice($pickupId, $totalPrice)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO total_price (pickup_id, total_price) VALUES (?, ?)");
            return $stmt->execute([$pickupId, $totalPrice]);
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getTotalByPickupId($pickupId)
    {
        $stmt = $this->db->prepare("SELECT * FROM total_price WHERE pickup_id = ?");
        $stmt->execute([$pickupId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTotalPrice($pickupId, $total, $discount, $code)
    {
        $stmt = $this->db->prepare("UPDATE total_price SET total_price = ?, discount = ?, coupon_code = ? WHERE pickup_id = ?");
        return $stmt->execute([$total, $discount, $code, $pickupId]);
    }

    public function insertTotalPrice($pickupId, $total, $discount, $code)
    {
        $stmt = $this->db->prepare("INSERT INTO total_price (pickup_id, total_price, discount, coupon_code) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$pickupId, $total, $discount, $code]);
    }


    public function getAllPickupItems()
    {
        $stmt = $this->db->query("SELECT * FROM pickup_items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllTotals()
    {
        $stmt = $this->db->query("SELECT * FROM total_price");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPickupItemsByPickupId($pickupId)
    {
        $stmt = $this->db->prepare("SELECT * FROM pickup_items WHERE pickup_id = ?");
        $stmt->execute([$pickupId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
