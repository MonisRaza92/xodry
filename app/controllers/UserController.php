<?php
namespace App\Controllers;
use App\Models\UserModel;

class UserController{
    public function updateProfile()
    {
        // User ID from session
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->alertAndRedirect('User not logged in');
            return;
        }

        // Check request method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->alertAndRedirect('Invalid request method');
            return;
        }

        // Form values
        $name    = trim($_POST['name'] ?? '');
        $number  = trim($_POST['number'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');

        // Update in DB
        $userModel = new UserModel($userId);
        $updated = $userModel->updateUser($userId, $name, $number, $email, $address);

        if ($updated) {
            $this->alertAndRedirect('User details updated');
        } else {
            $this->alertAndRedirect('Update failed');
        }
    }

    private function alertAndRedirect($message)
    {
        echo "<script>alert('".addslashes($message)."');window.location.href='home';</script>";
        exit;
    }
    
}