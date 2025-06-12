<?php

namespace App\Controllers;

use App\Models\PickupsModel;

class  RiderController{
    private $pickupModel;

    public function __construct(){
        // Start session if not already started
        $this->pickupModel = new PickupsModel();
    }
    public function index(){
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

        $stats = $this->pickupModel->getRiderPickupStats($rider_id);
        $pickups = $this->pickupModel->getPickupsByRider($rider_id);
        $completedPickups = $this->pickupModel->getCompletedPickupsByRider($rider_id);
        include_once __DIR__. '/../views/rider/index.php';
        exit();
    }
}