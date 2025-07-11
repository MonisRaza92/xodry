<?php

namespace App\Controllers;

use App\Models\RiderModel;
use App\Models\PickupItemsModel;
use App\Models\ServiceModel;
use App\Models\PickupsModel;

class RiderController
{
    private $riderModel;
    private $statuses;
    private $pickupItemModel;
    private $pickupsModel;
    private $serviceModel;

    public function __construct()
    {
        // Start session if not already started
        $this->riderModel = new RiderModel();
        $this->pickupItemModel = new PickupItemsModel();
        $this->pickupsModel = new PickupsModel();
        $this->serviceModel = new ServiceModel();
        $this->statuses = [
            'Assigned For Pickup',
            'Pickup Pending',
            'Going For Pickup',
            'Picked Up',
            'Dropped at Store',
            'Assigned For Delivery',
            'Out For Delivery',
            'Delivered',
            'Cancelled'
        ];
    }
    private function canChangeStatus($currentStatus, $newStatus)
    {
        $currentIndex = array_search($currentStatus, $this->statuses);
        $newIndex = array_search($newStatus, $this->statuses);

        // Rider can only move 1 step forward or Cancelled
        return ($newStatus === 'Cancelled') || ($newIndex === $currentIndex + 1);
    }
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        // Check if user role is set and is 'rider'
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'rider') {
            header('Location: home');
            exit();
        }
        $rider_id = $_SESSION['user_id'];
        $riderId = $_SESSION['user_id']; // assuming rider login ID stored here
        $pickupStatuses = ['Assigned For Pickup', 'Pickup Pending', 'Going For Pickup', 'Picked Up', 'Dropped at Store'];
        $deliveryStatuses = ['Assigned For Delivery', 'Out For Delivery', 'Delivered'];

        $pickupCategory = [];
        $deliveryCategory = [];

        $pickups = $this->riderModel->getPickupsByRider($riderId);
        foreach ($pickups as $pickup) {
            if (in_array($pickup['status'], $pickupStatuses)) {
                $pickupCategory[] = $pickup;
            } elseif (in_array($pickup['status'], $deliveryStatuses)) {
                $deliveryCategory[] = $pickup;
            }
        }

        $stats = $this->riderModel->getRiderPickupStats($riderId);
        $user = $this->riderModel->getUserByPickupId($riderId);
        $statuses = $this->statuses;
        $completedPickups = $this->riderModel->getCompletedPickupsByRider($riderId);
        $history = $this->riderModel->getRiderHistory($riderId);
        $categories = $this->riderModel->getAllCategories();
        $services = $this->riderModel->getAllServices();
        $demoServices = $this->serviceModel->getAllDemoServices();

        include_once __DIR__ . '/../views/rider/index.php';
        exit();
    }
    public function changePickupStatus()
    {
        $pickupId = $_POST['pickup_id'];
        $newStatus = $_POST['new_status'];
        $riderId = $_SESSION['user_id'];

        $currentStatus = $this->riderModel->getCurrentStatus($pickupId);

        // Backend guard: Picked Up status yaha allowed nahi hai
        if ($newStatus === 'Picked Up') {
            $_SESSION['msg'] = "❌ You must fill pickup details before marking as Picked Up.";
            header("Location: rider");
            exit();
        }

        if ($this->canChangeStatus($currentStatus, $newStatus)) {
            $this->riderModel->updateStatusByRider($pickupId, $newStatus);

            $stage = 'Pickup';
            if ($newStatus == 'Dropped at Store') {
                $stage = 'Pickup';
            } elseif ($newStatus == 'Out For Delivery' || $newStatus == 'Delivered') {
                $stage = 'Delivery';
            }

            $this->riderModel->insertPickupLog($pickupId, $riderId, $stage, $newStatus);

            $_SESSION['msg'] = "✅ Status updated to $newStatus and logged!";
        } else {
            $_SESSION['msg'] = "❌ Invalid move! You can only go one step ahead.";
        }

        header("Location: rider");
        exit();
    }


    public function getServices()
    {
        $categoryId = $_POST['category_id'];

        $services = $this->serviceModel->getServicesByCategory($categoryId);

        header('Content-Type: application/json'); // ✅ Force JSON response
        echo json_encode($services);
        exit; // ✅ Stop further output (important)
    }


    public function savePickupItems()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'rider') {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }

        $pickupId = $_POST['pickup_id'];
        $lists = json_decode($_POST['items'], true);
        $totalPrice = $_POST['grand_total'] ?? 0;

        // ✅ Loop over all item lists
        foreach ($lists as $list) {
            $categoryId = $list['category_id'];
            $items = $list['items'];

            foreach ($items as $item) {
                $serviceId = $item['service_id'];
                $quantity = $item['quantity'];
                $price = $item['total_price'];
                $comment = $item['comment'] ?? '';

                // Save each item individually
                $this->pickupItemModel->savePickupItemWithComment(
                    $pickupId,
                    $categoryId,
                    $serviceId,
                    $quantity,
                    $price,
                    $comment
                );
            }
        }

        // ✅ Save total price (or with discount if added later)
        $this->pickupItemModel->saveTotalPrice($pickupId, $totalPrice);

        // ✅ Update status
        $currentStatus = $this->riderModel->getCurrentStatus($pickupId);
        $newStatus = 'Picked Up';
        $riderId = $_SESSION['user_id'];

        if ($this->canChangeStatus($currentStatus, $newStatus)) {
            $this->riderModel->updateStatusByRider($pickupId, $newStatus);
            $this->riderModel->insertPickupLog($pickupId, $riderId, 'Pickup', $newStatus);

            echo json_encode(['status' => 'success', 'message' => 'Items saved and status updated to Picked Up!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid status change!']);
        }
    }

}
