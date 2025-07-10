<?php

namespace App\Models;

use Core\Database;
use PDO;

class DiscountModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM discount_codes ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($code, $type, $value)
    {
        $stmt = $this->db->prepare("INSERT INTO discount_codes (code, type, value) VALUES (?, ?, ?)");
        return $stmt->execute([$code, $type, $value]);
    }

    public function toggleStatus($id, $newStatus)
    {
        $stmt = $this->db->prepare("UPDATE discount_codes SET status = ? WHERE id = ?");
        return $stmt->execute([$newStatus, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM discount_codes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getByCode($code)
    {
        $stmt = $this->db->prepare("SELECT * FROM discount_codes WHERE code = ? LIMIT 1");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
