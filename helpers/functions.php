<?php

namespace helpers;

use App\Models\UserModel;

class HelperFunctions
{
    public static function getNavbarData()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            return [
                'orderCount' => 0,
                'pickupList' => []
            ];
        }

        $userModel = new UserModel($userId);

        // Ye list return karega
        $pickupList = $userModel->showAllPickupsByUserId($userId);
        $pickupList = array_reverse($pickupList);

        // Count nikalo list ka
        $orderCount = is_array($pickupList) ? count($pickupList) : 0;

        return [
            'orderCount' => $orderCount,
            'pickupList' => $pickupList
        ];
    }
    public static function userDetails()
    {
        $userId = $_SESSION['user_id'] ?? null;

        $userDetails = null;
        if ($userId) {
            $userModel = new UserModel($userId);
            $userDetails = $userModel->getUserById($userId);
        }

        return $userDetails;
    }
}
