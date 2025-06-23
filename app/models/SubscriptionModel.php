<?php

namespace App\Models;

use Core\Database;
use PDO;            
use PDOException;

class  SubscriptionModel
{
    private $db;

    public function __construct()
    {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }

    public function getAllSubscriptions()
    {
        $stmt = $this->db->query("SELECT * FROM subscriptions");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubscriptionById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM subscriptions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSubscription($title, $price, $point1, $point2, $point3, $point4, $point5, $button_text, $button_link)
    {
        $stmt = $this->db->prepare("INSERT INTO subscriptions (title, price, point1, point2, point3, point4, point5, button_text, button_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $price, $point1, $point2, $point3, $point4, $point5, $button_text, $button_link]);
    }

    public function updateSubscription($id, $title, $price, $point1, $point2, $point3, $point4, $point5, $button_text, $button_link)
    {
        $stmt = $this->db->prepare("UPDATE subscriptions SET title = ?, price = ?, point1 = ?, point2 = ?, point3 = ?, point4 = ?, point5 = ?, button_text = ?, button_link = ? WHERE id = ?");
        return $stmt->execute([$title, $price, $point1, $point2, $point3, $point4, $point5, $button_text, $button_link, $id]);
    }

    public function deleteSubscription($id)
    {
        $stmt = $this->db->prepare("DELETE FROM subscriptions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}