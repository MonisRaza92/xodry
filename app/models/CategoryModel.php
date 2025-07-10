<?php


namespace App\Models;

use Core\Database;
use PDO;
use PDOException;
use App\Constants\PickupStatus;

class CategoryModel
{
    private $db;

    public function __construct()
    {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }

    public function getAllCategories()
    {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCategoryForCard()
    {
        $stmt = $this->db->query("SELECT * FROM categories WHERE visibility = 'for page card'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategoryNameById($categoryId)
    {
        $stmt = $this->db->prepare("SELECT category_name FROM categories WHERE id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchColumn();
    }

    public function addCategory($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO categories 
            (image, category_name, description, bullet_point_1, bullet_point_2, bullet_point_3, bullet_point_4, bullet_point_5, visibility) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['image'],
            $data['category_name'],
            $data['description'],
            $data['bullet_point_1'],
            $data['bullet_point_2'],
            $data['bullet_point_3'],
            $data['bullet_point_4'],
            $data['bullet_point_5'],
            $data['visibility'],
        ]);
    }
    public function updateCategory($data)
    {
        $stmt = $this->db->prepare("
            UPDATE categories
            SET image = ?, category_name = ?, description = ?, bullet_point_1 = ?, bullet_point_2 = ?, bullet_point_3 = ?, bullet_point_4 = ?, bullet_point_5 = ?, visibility = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['image'],
            $data['category_name'],
            $data['description'],
            $data['bullet_point_1'],
            $data['bullet_point_2'],
            $data['bullet_point_3'],
            $data['bullet_point_4'],
            $data['bullet_point_5'],
            $data['visibility'],
            $data['id'], // Assuming 'id' is part of the $data array
        ]);
    }
    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
