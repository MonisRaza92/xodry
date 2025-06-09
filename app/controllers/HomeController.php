<?php

namespace App\Controllers;
use App\Models\UserModel;

class HomeController
{
    public function index()
    {
        include_once __DIR__. '/../views/home/index.php';
    }
    public function about()
    {
        include_once __DIR__. '/../views/home/about.php';
    }
    public function services()
    {
        include_once __DIR__. '/../views/home/sevices.php';
    }
}
