<?php

namespace App\Controllers;

include  __DIR__. '/../../vendor/autoload.php';

use App\Models\PickupsModel;
use App\Models\AuthModel;
use App\Constants\PickupStatus;
use App\Models\UserModel;
use Core\Database;

class PickupsController
{
    private $db;
    private $authModel;
    private $userModel;
    private $pickupsModel;

    public function __construct()
    {
        $database = new Database(); // ✅ Your custom DB wrapper
        $this->db = $database->connect();
        $this->authModel = new AuthModel( $this->db );
        $this->userModel = new UserModel($this->db);
        $this->pickupsModel = new PickupsModel();
    }
    public function createPickup()
    {
        header('Content-Type: application/json');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $pickup_date = $_POST['pickup_date'];
            $pickup_time = $_POST['pickup_time'];
            $number = $_POST['number'];
            $email = $_POST['email'] ?? null;
            $address = $_POST['address'];
            $password = $_POST['password'] ?? null;

            $authModel = new AuthModel( $this->db);
            $userModel = new UserModel($this->db);
            $pickupModel = new PickupsModel();

            $user_id = $_SESSION['user_id'] ?? null;

            // Step 1: If not logged in → check user by number
            if (!$user_id) {
                $user = $authModel->getUserByNumber($number);
                
                if (!$user) {
                    $newUser = $authModel->createUser($name, $number, $email, $address, $password); // ✅ FIXED LINE
                    $user = $authModel->getUserByNumber($number);
                    $user_id = $user['id'];
                    $_SESSION['user_id'] = $user_id;
                } else {
                    $user_id = $user['id'];
                    $_SESSION['user_id'] = $user_id;

                    if (empty($user['name']) || empty($user['address'])) {
                        $userModel->updateUser($user_id, $name, $number, $email, $address);
                    }
                }
            }

            // Step 2: Create pickup
            if (!$user_id) {
                echo json_encode(['status' => 'error', 'message' => 'User not found']);
                return;
            }
            $result = $pickupModel->createPickups($user_id, $name, $pickup_date, $pickup_time, $number, $address);

            if ($result === true) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $result]);
            }
        }
    }

    public function cancelPickupStatus()
    {
        header('Content-Type: application/json');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Invalid request method');
            }

            if (!isset($_POST['pickup_id'])) {
                throw new \Exception('Pickup ID is required');
            }

            $pickup_id = $_POST['pickup_id'];

            if (!is_numeric($pickup_id)) {
                throw new \Exception('Invalid pickup ID format');
            }

            $result = $this->pickupsModel->updatePickupStatusCancel($pickup_id);

            if ($result === true) {
                echo json_encode(['status' => 'success', 'message' => 'Pickup cancelled successfully']);
                header('Location: home'); // Redirect to home after cancellation
            } else {
                echo json_encode(['status' => 'error', 'message' => $result]);
                header('Location: home'); // Redirect to home after cancellation
            }
        } catch (\Exception $e) {
            error_log("Error in cancelPickupStatus: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            header('Location: home'); // Redirect to home after cancellation
        }
        exit;
    }
    public function updatePickupStatus()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pickup_id = $_POST['pickup_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if (!$pickup_id || !$status) {
                echo json_encode(['status' => 'error', 'message' => 'pickup_id and status are required']);
                exit;
            }

            $result = $this->pickupsModel->updatePickupStatus($pickup_id, $status);

            if ($result === true) {
                echo json_encode(['status' => 'success', 'message' => 'Pickup status updated']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update pickup status']);
            }
        }
        exit;
    }
}