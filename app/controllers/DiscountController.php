<?php

namespace App\Controllers;

use App\Models\DiscountModel;
use App\Models\PickupItemsModel;

class DiscountController
{
    private $discountModel;
    private $pickupItemsModel;

    public function __construct()
    {
        $this->discountModel = new DiscountModel();
        $this->pickupItemsModel = new PickupItemsModel();
    }
    public function create()
    {
        $code = $_POST['code'] ?? '';
        $type = $_POST['type'] ?? '';
        $value = $_POST['value'] ?? '';

        if ($code && $type && $value) {
            $result = $this->discountModel->create($code, $type, $value);
        } else {
            $result = "Missing required fields.";
        }

        if ($result === true) {
            echo "<script>alert('Discount added successfully!');window.location.href='admin-discounts';</script>";
        } else {
            echo "<script>alert('Failed to add discount: {$result}');window.location.href='admin-discounts';</script>";
        }
        exit;
    }
    public function toggle()
    {
        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($id && $status) {
            $result = $this->discountModel->toggleStatus($id, $status);
        } else {
            $result = "Missing required fields.";
        }

        if ($result === true) {
            echo "<script>alert('Discount status updated successfully!');window.location.href='admin-discounts';</script>";
        } else {
            echo "<script>alert('Failed to update discount status: {$result}');window.location.href='admin-discounts';</script>";
        }
        exit;
    }
    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if ($id) {
            $result = $this->discountModel->delete($id);
        } else {
            $result = "Missing required fields.";
        }

        if ($result === true) {
            echo "<script>alert('Discount deleted successfully!');window.location.href='admin-discounts';</script>";
        } else {
            echo "<script>alert('Failed to delete discount: {$result}');window.location.href='admin-discounts';</script>";
        }
        exit;
    }
    public function applyDiscount()
    {
        session_start();
        $code = $_POST['code'] ?? '';
        $pickupId = $_POST['pickup_id'] ?? null;
        $grandTotal = floatval($_POST['grand_total'] ?? 0);

        if (!$code || !$pickupId || $grandTotal <= 0) {
            $_SESSION['msg'] = 'Invalid input.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $coupon = $this->discountModel->getByCode($code);

        if (!$coupon || $coupon['status'] !== 'active') {
            $_SESSION['msg'] = 'Invalid or inactive coupon code.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Calculate discount
        if ($coupon['type'] === 'percent') {
            $discountAmount = ($grandTotal * $coupon['value']) / 100;
        } else {
            $discountAmount = $coupon['value'];
        }

        $discountAmount = min($discountAmount, $grandTotal);
        $couponCode = $code;

        // Insert or update total_price table
        $existing = $this->pickupItemsModel->getTotalByPickupId($pickupId);

        if ($existing) {
            $this->pickupItemsModel->updateTotalPrice($pickupId, $grandTotal, $discountAmount, $couponCode);
        } else {
            $this->pickupItemsModel->insertTotalPrice($pickupId, $grandTotal, $discountAmount, $couponCode);
        }

        $_SESSION['msg'] = "Coupon applied";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }


}
