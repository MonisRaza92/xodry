<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\CategoryModel;
use Core\Database; // Add this line if Database class is in App\Core namespace
use App\Models\ServiceModel; // Assuming you have a ServiceModel for services
use App\Models\SubscriptionModel; // Assuming you have a SubscriptionModel for subscriptions
use App\Models\PickupItemsModel; // Assuming you have a SubscriptionModel for subscriptions
use App\Models\PickupsModel; // Assuming you have a SubscriptionModel for subscriptions

class HomeController
{
    private $catModel;
    private $ServiceModel;
    private $SubscriptionModel;
    private $pickupItemModel;
    private $pickupsModel;

    public function __construct()
    {
        // Assuming you have a Database class or method to get the connection
        $db = new Database(); // Or use your actual DB connection method
        $this->catModel = new CategoryModel();
        $this->ServiceModel = new ServiceModel();
        $this->SubscriptionModel = new SubscriptionModel();
        $this->pickupItemModel = new PickupItemsModel();
        $this->pickupsModel = new PickupsModel();
    }

    public function index()
    {
        $categories = $this->catModel->getAllCategories();
        $subscriptions = $this->SubscriptionModel->getAllSubscriptions();
        include_once __DIR__. '/../views/home/index.php';
    }
    public function about()
    {
        include_once __DIR__. '/../views/home/about.php';
    }
    public function services()
    {
        $categories = $this->catModel->getAllCategories();
        $subscriptions = $this->SubscriptionModel->getAllSubscriptions();
        include_once __DIR__. '/../views/home/sevices.php';
    }
    public function prices()
    {
        $serviceListByCategory = $this->ServiceModel->getServicesByCategoryName();
        include_once __DIR__. '/../views/home/prices.php';
    }
}
