<?php

namespace App\Controllers;


class  RiderController{
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
        include_once __DIR__. '/../views/rider/index.php';
        exit();
    }
}