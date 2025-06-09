<?php

namespace App\Controllers;

include  __DIR__. '/../../vendor/autoload.php';

use App\Models\AuthModel;
use App\Models\PickupsModel;

class PickupsController{
    private $userModel;
    private $pickupsModel;
    public function __construct()
    {
        $this->userModel = new AuthModel();
        $this->pickupsModel = new PickupsModel();
    }
    public function createPickup()
    {
        header('Content-Type: application/json');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = $_POST['name'];
            $pickup_date = $_POST['pickup_date'];
            $number   = $_POST['number'];
            $email = $_POST['email'] ?? null;
            $address  = $_POST['address'];
            $password = $_POST['password'] ?? null;

            $userModel = new AuthModel();
            $pickupModel = new PickupsModel();

            $user_id = $_SESSION['user_id'] ?? null;

            // Step 1: If not logged in → check user by number
            if (!$user_id) {
                $user = $userModel->getUserByNumber($number);

                if (!$user) {
                    // Register and login
                    $user_id = $userModel->createUser($name, $number, $email, $address, $password);
                    $_SESSION['user_id'] = $user_id;
                } else {
                    // Login existing user
                    $user_id = $user['id'];
                    $_SESSION['user_id'] = $user_id;

                    // Optional: update incomplete profile
                    if (empty($user['name']) || empty($user['address'])) {
                        $userModel->updateUser($user_id, $name, $number, $email, $address);
                    }
                }
            }

            // Step 2: Create pickup
            $result = $pickupModel->pickups($user_id, $name, $pickup_date, $number, $address);

            if ($result === true) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $result]);
            }
        }
    }

    public function changePickupStatus(){
        $user_id = $_SESSION['user_id'] ?? null;
        
    }
}