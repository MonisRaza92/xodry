<?php



namespace App\Models;

use Core\Database;
use PDO;
use PDOException;
use App\Constants\PickupStatus;

class ServiceModel
{
    private $db;

    public function __construct($db)
    {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }
    public function getServicesByCategory()
    {
        $stmt = $this->db->query("
            SELECT s.*, c.category_name FROM services s
            JOIN categories c ON s.category_id = c.id
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addService($category_id, $service_name, $price)
    {
        $stmt = $this->db->prepare("INSERT INTO services (category_id, service_name, price) VALUES (?, ?, ?)");
        return $stmt->execute([$category_id, $service_name, $price]);
    }
    public function deletePrice($id)
    {
        $stmt = $this->db->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
