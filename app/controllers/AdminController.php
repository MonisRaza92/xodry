<?php

namespace App\Controllers;

use Core\Database;
use App\Models\PickupsModel;

class AdminController
{
    private $adminModel;
    private $userModel;
    private $pickupsModel;
    private $db;
    private $catModel;
    private $serviceModel;
    private $pickupItemsModel;

    private $subscriptionModel;
    private $discountModel;


    public function __construct()
    {
        $database = new Database(); // ✅ Your custom DB wrapper
        $this->db = $database->connect();
        $this->adminModel = new \App\Models\AdminModel();
        $this->userModel = new \App\Models\UserModel($this->db);
        $this->pickupsModel = new PickupsModel();
        $this->catModel = new \App\Models\CategoryModel();
        $this->serviceModel = new \App\Models\ServiceModel();
        $this->pickupItemsModel = new \App\Models\PickupItemsModel();
        $this->subscriptionModel = new \App\Models\SubscriptionModel();
        $this->discountModel = new \App\Models\DiscountModel();

    }

    public function index()
    {
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
        include_once __DIR__ . '/../views/admin/index.php';
        exit();
    }
    public function users()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }
        $users = $this->userModel->getAllUsersWithPickupCount();

        include_once __DIR__ . '/../views/admin/adminUsers.php';
        exit();
    }
    public function deleteUser()
    {
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
    public function riders()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }
        $riders = $this->userModel->getAllRiders();
        include_once __DIR__ . '/../views/admin/adminRiders.php';
        exit();
    }
    public function deleteRider()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $deleted = $this->userModel->deleteUser($id);
            if ($deleted) {
                echo "<script>alert('Rider deleted successfully');window.location.href='admin-riders';</script>";
            } else {
                echo "<script>alert('Failed to delete Rider');window.location.href='admin-riders';</script>";
            }
        } else {
            echo "<script>alert('Invalid Rider ID');window.location.href='admin-riders';</script>";
        }
    }
    public function orders()
    {
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
        $pickupItems = $this->pickupItemsModel->getAllPickupItems(); // get all items for all pickups
        $categories = $this->catModel->getAllCategories(); // All category names
        $servicesName = $this->serviceModel->getAllServices(); // All service names
        $pickupTotals = $this->pickupItemsModel->getAllTotals();

        include_once __DIR__ . '/../views/admin/adminOrders.php';
        exit();
    }

    public function services()
    {
        $catModel = new \App\Models\CategoryModel();
        $categories = $catModel->getAllCategories();
        $demoServices = $this->serviceModel->getAllDemoServices();

        include __DIR__ . '/../views/admin/adminServices.php';
        exit();
    }
    public function prices()
    {
        $catModel = new \App\Models\CategoryModel();
        $serviceModel = new \App\Models\ServiceModel();
        $categories = $catModel->getAllCategories();
        $servicesByCategory = $serviceModel->getServicesByCategoryName();
        include_once __DIR__ . '/../views/admin/adminPrices.php';
        exit();
    }
    public function discounts()
    {
        $discounts = $this->discountModel->getAll();
        include_once __DIR__ . '/../views/admin/adminDiscount.php';
        exit();
    }
    public function settings()
    {
        $images = $this->adminModel->getAllSliderImages();
        $compare = $this->adminModel->getAllCompareImages();
        include_once __DIR__ . '/../views/admin/adminSettings.php';
        exit();
    }
    public function addRider()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $number = $_POST['number'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $authModel = new \App\Models\AuthModel($this->db);
            $result = $authModel->createRider($name, $number, $email, $address, $password);

            if ($result === true) {
                echo "<script>alert('Rider added successfully!');window.location.href='admin-riders';</script>";
            } else {
                echo "<script>alert('Failed to add rider: {$result}');window.location.href='admin-riders';</script>";
            }
        }
    }
    public function addDemoService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';

            $result = $this->serviceModel->addDemoService($name);
            if ($result === true) {
                echo "<script>alert('Service added successfully!');window.location.href='admin-services';</script>";
            } else {
                echo "<script>alert('Failed to add Service: {$result}');window.location.href='admin-services';</script>";
            }
        }
    }
    public function deleteDemoService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            $result = $this->serviceModel->deleteDemoService($id);
            if ($result === true) {
                echo "<script>alert('Service added successfully!');window.location.href='admin-services';</script>";
            } else {
                echo "<script>alert('Failed to add Service: {$result}');window.location.href='admin-services';</script>";
            }
        }
    }

    public function addCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image = 'uploads/' . $_FILES['image']['name'];
            $uploadPath = __DIR__ . '/../../public/' . $image; // full server path

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
                'bullet_point_3' => $_POST['bullet_point_3'],
                'bullet_point_4' => $_POST['bullet_point_4'],
                'bullet_point_5' => $_POST['bullet_point_5'],
                'visibility' => $_POST['visibility'],
            ];

            $categoryModel = new \App\Models\CategoryModel();
            $result = $categoryModel->addCategory($data);

            if ($result) {
                echo "<script>alert('Category added successfully!');window.location.href='admin-services';</script>";
            } else {
                echo "<script>alert('Failed to add category!');window.location.href='admin-services';</script>";
            }
        }
    }
    public function updateCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['category_id'];
            if (!empty($_FILES['image']['name'])) {
                $image = 'uploads/' . $_FILES['image']['name'];
                $uploadPath = __DIR__ . '/../../public/' . $image; // full server path
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    die('Image upload failed.');
                }
            } else {
                $image = $_POST['existing_image']; // keep the existing image
            }

            $data = [
                'id' => $id,
                'image' => $image,
                'category_name' => $_POST['category_name'],
                'description' => $_POST['description'],
                'bullet_point_1' => $_POST['bullet_point_1'],
                'bullet_point_2' => $_POST['bullet_point_2'],
                'bullet_point_3' => $_POST['bullet_point_3'],
                'bullet_point_4' => $_POST['bullet_point_4'],
                'bullet_point_5' => $_POST['bullet_point_5'],
                'visibility' => $_POST['visibility'],
            ];

            $categoryModel = new \App\Models\CategoryModel();
            $result = $categoryModel->updateCategory($data);

            if ($result) {
                echo "<script>alert('Category updated successfully!');window.location.href='admin-services';</script>";
            } else {
                echo "<script>alert('Failed to update category!');window.location.href='admin-services';</script>";
            }
        }
    }
    public function deleteService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['category_id'];
            $deleteServiceModel = new \App\Models\CategoryModel();
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
            $visibility = $_POST['visibility'];
            $serviceModel = new \App\Models\ServiceModel();
            $serviceModel->addService($cat_id, $name, $price, $visibility);
            header("Location: admin-prices");
            exit;
        }
    }
    public function deletePrice()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['service_id'];
            $serviceModel = new \App\Models\ServiceModel();
            $deleted = $serviceModel->deleteService($id);
            if ($deleted) {
                echo "<script>alert('Price deleted successfully');window.location.href='admin-prices';</script>";
            } else {
                echo "<script>alert('Failed to delete price');window.location.href='admin-prices';</script>";
            }
        }
    }
    public function subscriptions()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }

        $subscriptions = $this->subscriptionModel->getAllSubscriptions();
        include_once __DIR__ . '/../views/admin/adminSubscriptions.php';
        exit();
    }

    public function addSubscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $price = $_POST['price'] ?? '';
            $point1 = $_POST['point1'] ?? '';
            $point2 = $_POST['point2'] ?? '';
            $point3 = $_POST['point3'] ?? '';
            $point4 = $_POST['point4'] ?? '';
            $point5 = $_POST['point5'] ?? '';
            $button_text = $_POST['button_text'] ?? '';
            $button_link = $_POST['button_link'] ?? '';

            $subscriptionModel = new \App\Models\SubscriptionModel();
            $subscription = $subscriptionModel->addSubscription(
                $title,
                $price,
                $point1,
                $point2,
                $point3,
                $point4,
                $point5,
                $button_text,
                $button_link
            );

            if ($subscription) {
                echo "<script>alert('Subscription added successfully!');window.location.href='admin-subscriptions';</script>";
            } else {
                echo "<script>alert('Failed to add subscription!');window.location.href='admin-subscriptions';</script>";
            }
        }
    }
    public function deleteSubscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['subscription_id'] ?? null;

            if ($id) {
                $subscriptionModel = new \App\Models\SubscriptionModel();
                $deleted = $subscriptionModel->deleteSubscription($id);

                if ($deleted) {
                    echo "<script>alert('Subscription deleted successfully!');window.location.href='admin-subscriptions';</script>";
                } else {
                    echo "<script>alert('Failed to delete subscription!');window.location.href='admin-subscriptions';</script>";
                }
            } else {
                echo "<script>alert('Invalid subscription ID!');window.location.href='admin-subscriptions';</script>";
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
    // Upload Image
    public function sliderImageAdd()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image = 'uploads/' . $_FILES['image']['name'];
            $uploadPath = __DIR__ . '/../../public/' . $image; // full server path

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                // move success
            } else {
                die('Image upload failed.');
            }

            $result = $this->adminModel->sliderImageAdd($image);

            if ($result) {
                echo "<script>alert('Image added successfully!');window.location.href='admin-settings';</script>";
            } else {
                echo "<script>alert('Failed to add Image!');window.location.href='admin-settings';</script>";
            }

        }
    }

    // Delete Image
    public function sliderImageDelete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "<script>alert('ID not found');window.location.href='admin-settings';</script>";
            exit;
        }

        $deleted = $this->adminModel->sliderImageDelete($id);
        if ($deleted) {
            echo "<script>alert('Image deleted successfully');window.location.href='admin-settings';</script>";
        } else {
            echo "<script>alert('Failed to delete Image');window.location.href='admin-settings';</script>";
        }
        exit;
    }
    // Add Before & After Image
    public function compareImageAdd()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $before = $_FILES['before_image'];
            $after = $_FILES['after_image'];

            $beforeName = 'uploads/' . uniqid() . '_' . $before['name'];
            $afterName = 'uploads/' . uniqid() . '_' . $after['name'];

            $beforePath = __DIR__ . '/../../public/' . $beforeName;
            $afterPath = __DIR__ . '/../../public/' . $afterName;

            if (!move_uploaded_file($before['tmp_name'], $beforePath) || !move_uploaded_file($after['tmp_name'], $afterPath)) {
                die('Image upload failed.');
            }

            $result = $this->adminModel->compareImageAdd($beforeName, $afterName);

            if ($result) {
                echo "<script>alert('Before/After images added successfully!');window.location.href='admin-settings';</script>";
            } else {
                echo "<script>alert('Failed to add images!');window.location.href='admin-settings';</script>";
            }
        }
    }

    // Delete Compare Images by ID
    public function compareImageDelete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "<script>alert('ID not found');window.location.href='admin-settings';</script>";
            exit;
        }

        $deleted = $this->adminModel->compareImageDelete($id);

        if ($deleted) {
            echo "<script>alert('Compare images deleted successfully!');window.location.href='admin-settings';</script>";
        } else {
            echo "<script>alert('Failed to delete images!');window.location.href='admin-settings';</script>";
        }

        exit;
    }



}