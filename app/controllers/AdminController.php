<?php

namespace App\Controllers;

use Core\Database;
use App\Models\PickupsModel;

class AdminController{
    private $userModel;
    private $pickupsModel;
    private $db;
    private $catModel;


    public function __construct() {
        $this->db = new Database(); 
        $this->userModel = new \App\Models\UserModel($this->db);
        $this->pickupsModel = new  PickupsModel();
        $this->catModel = new \App\Models\CategoryModel($this->db);
    }

    public function index(){
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }
        $users = $this->userModel->getAllUsers();
        $riders = $this->userModel->getAllRiders();
        $categories = $this->catModel->getAllCategories();
        include_once __DIR__. '/../views/admin/index.php';
        exit();
    }
    public function users(){
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }
        $users = $this->userModel->getAllUsers();
        include_once __DIR__. '/../views/admin/adminUsers.php';
        exit();
    }
    public function deleteUser(){
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }
        $id = $_POST['id'] ?? null;
        if ($id) {
            $deleted = $this->userModel->deleteUser($id);
            if ($deleted) {
                echo "<script>alert('User deleted successfully');window.location.href='admin-users';</script>";
            } else {
                echo "<script>alert('Failed to delete user');window.location.href='admin-users';</script>";
            }
        } else {
            echo "<script>alert('Invalid user ID');window.location.href='admin-users';</script>";
        }
    }
    public function riders(){
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }
        $riders = $this->userModel->getAllRiders();
        include_once __DIR__. '/../views/admin/adminRiders.php';
        exit();
    }
    public function orders(){
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }
        $pickups = $this->pickupsModel->getAllPickups();
        $riders = $this->userModel->getAllRiders();
        $pickupStatus = $this->pickupsModel->getAllPickupsStatus();
        include_once __DIR__. '/../views/admin/adminOrders.php';
        exit();
    }
    public function services(){
        $catModel = new \App\Models\CategoryModel($this->db);
        $categories = $catModel->getAllCategories();

        include __DIR__. '/../views/admin/adminServices.php';
        exit();
    }
    public function prices()
    {
        $catModel = new \App\Models\CategoryModel($this->db);
        $serviceModel = new \App\Models\ServiceModel($this->db);
        $categories = $catModel->getAllCategories();
        $services = $serviceModel->getServicesByCategory();
        include_once __DIR__ . '/../views/admin/adminPrices.php';
        exit();
    }

    public function addCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image = 'uploads/' . $_FILES['image']['name'];
            $uploadPath = __DIR__. '/../../public/' . $image; // full server path

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                // move success
            } else {
                die('Image upload failed.');
            }

            $data = [
                'image' => $image,
                'category_name' => $_POST['category_name'],
                'description' => $_POST['description'],
                'bullet_point_1' => $_POST['bullet_point_1'],
                'bullet_point_2' => $_POST['bullet_point_2'],
                'bullet_point_3' => $_POST['bullet_point_3']
            ];

            $categoryModel = new \App\Models\CategoryModel($this->db);
            $result = $categoryModel->addCategory($data);

            if ($result) {
                echo "<script>alert('Category added successfully!');window.location.href='admin-services';</script>";
            } else {
                echo "<script>alert('Failed to add category!');window.location.href='admin-services';</script>";
            }
        }
    }
    public function deleteService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['category_id'];
            $deleteServiceModel = new \App\Models\CategoryModel($this->db);
            $deleted = $deleteServiceModel->deleteCategory($id);
            if ($deleted) {
                echo "<script>alert('Service deleted successfully');window.location.href='admin-services';</script>";
            } else {
                echo "<script>alert('Failed to delete service');window.location.href='admin-services';</script>";
            }
        }
    }


    public function addServices()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cat_id = $_POST['category_id'];
            $name = $_POST['service_name'];
            $price = $_POST['price'];
            $serviceModel = new \App\Models\ServiceModel($this->db);
            $serviceModel->addService($cat_id, $name, $price);
            header("Location: admin-prices");
            exit;
        }
    }
    public function deletePrice()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['service_id'];
            $serviceModel = new \App\Models\ServiceModel($this->db);
            $deleted = $serviceModel->deletePrice($id);
            if ($deleted) {
                echo "<script>alert('Price deleted successfully');window.location.href='admin-prices';</script>";
            } else {
                echo "<script>alert('Failed to delete price');window.location.href='admin-prices';</script>";
            }
        }
    }
    public function assignRider()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pickup_id = $_POST['pickup_id'] ?? null;
            $rider_id = $_POST['rider_id'] ?? null;

            if ($pickup_id && $rider_id) {
                $result = $this->pickupsModel->assignRider($pickup_id, $rider_id);

                if ($result) {
                    // Success message
                    echo "<script>alert('Rider assigned successfully!');window.location.href='admin-orders';</script>";
                    exit;
                } else {
                    // Failure
                    echo "<script>alert('Failed to assign rider!');window.location.href='admin-orders';</script>";
                    exit;
                }
            } else {
                // Invalid data
                echo "<script>alert('Invalid data provided!');window.location.href='admin-orders';</script>";
                exit;
            }
        } else {
            // Invalid method
            echo "<script>alert('Invalid request method!');window.location.href='admin-orders';</script>";
            exit;
        }
    }
}