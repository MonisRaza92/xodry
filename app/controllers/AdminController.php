<?php

namespace App\Controllers;

class AdminController{
    public function index(){
        if (!isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }
        include_once __DIR__. '/../views/admin/index.php';
        exit();
    }
}