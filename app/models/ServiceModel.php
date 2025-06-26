<?php



namespace App\Models;

use Core\Database;
use PDO;
use PDOException;
use App\Constants\PickupStatus;

class ServiceModel
{
    private $db;

    public function __construct()
    {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }
    public function getServicesByCategoryName()
    {
        $stmt = $this->db->prepare("
            SELECT s.*, c.category_name FROM services s
            JOIN categories c ON s.category_id = c.id
        ");
        $stmt->execute(); // ✅ Don't forget this
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getServicesByCategory($categoryId)
    {
        $stmt = $this->db->prepare("
            SELECT s.*, c.category_name 
            FROM services s
            JOIN categories c ON s.category_id = c.id
            WHERE s.category_id = ?
        ");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllServices()
    {
        $stmt = $this->db->query("
            SELECT s.*, c.category_name FROM services s
            JOIN categories c ON s.category_id = c.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getServiceNameById($id)
    {
        $stmt = $this->db->prepare("SELECT service_name FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public function addService($category_id, $service_name, $price)
    {
        $stmt = $this->db->prepare("INSERT INTO services (category_id, service_name, price) VALUES (?, ?, ?)");
        return $stmt->execute([$category_id, $service_name, $price]);
    }
    public function deleteService($id)
    {
        $stmt = $this->db->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
