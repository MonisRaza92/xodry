<?php


namespace App\Models;

use Core\Database;
use PDO;
use PDOException;
use App\Constants\PickupStatus;

class AdminModel
{
    private $db;

    public function __construct()
    {
        $database = new Database(); // Custom Database class
        $this->db = $database->connect();
    }
    public function getAllSliderImages()
    {
        $stmt = $this->db->query("SELECT * FROM image_slider");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Add new image
    public function sliderImageAdd($imagePath)
    {
        $stmt = $this->db->prepare("INSERT INTO image_slider (image_url) VALUES (?)");
        return $stmt->execute([$imagePath]);
    }

    // Delete image by ID
    public function sliderImageDelete($id)
    {
        // First get image path
        $stmt = $this->db->prepare("SELECT image_url FROM image_slider WHERE id = ?");
        $stmt->execute([$id]);
        $img = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($img && file_exists($img['image_url'])) {
            unlink($img['image_url']); // delete file from server
        }

        // Now delete from DB
        $stmt = $this->db->prepare("DELETE FROM image_slider WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function getAllCompareImages()
    {
        $stmt = $this->db->query("SELECT * FROM image_compare");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Add new image
    public function compareImageAdd($before, $after)
    {
        $stmt = $this->db->prepare("INSERT INTO image_compare (before_image, after_image) VALUES (?,?)");
        return $stmt->execute([$before, $after]);
    }

    // Delete image by ID
    public function compareImageDelete($id)
    {
        // Get both before & after image paths
        $stmt = $this->db->prepare("SELECT before_image, after_image FROM image_compare WHERE id = ?");
        $stmt->execute([$id]);
        $img = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($img) {
            if (!empty($img['before_image']) && file_exists($img['before_image'])) {
                unlink($img['before_image']);
            }
            if (!empty($img['after_image']) && file_exists($img['after_image'])) {
                unlink($img['after_image']);
            }
        }

        // Delete row from DB
        $stmt = $this->db->prepare("DELETE FROM image_compare WHERE id = ?");
        return $stmt->execute([$id]);
    }



}