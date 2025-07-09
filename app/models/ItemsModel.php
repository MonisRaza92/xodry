<?php
namespace App\Models;
use Core\Database;
class ItemsModel
{
    private $db;

    public function __construct()
    {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }

    public function allWithService()
    {
        $stmt = $this->db->prepare("SELECT i.*, s.name AS service_name, s.category_id FROM items i JOIN services s ON i.service_id = s.id");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($name, $price, $service_id)
    {
        $stmt = $this->db->prepare("INSERT INTO items (name, price, service_id) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $price, $service_id]);
    }

    public function update($id, $name, $price, $service_id)
    {
        $stmt = $this->db->prepare("UPDATE items SET name = ?, price = ?, service_id = ? WHERE id = ?");
        return $stmt->execute([$name, $price, $service_id, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM items WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
