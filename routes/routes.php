<?php

use Core\Router;

global $router;
//Define Home Routes
$router->addRoute('GET', '/', 'HomeController@index');
$router->addRoute('GET', 'home', 'HomeController@index');
$router->addRoute('GET', 'about', 'HomeController@about');
$router->addRoute('GET', 'services', 'HomeController@services');
$router->addRoute('GET', 'pricing', 'HomeController@prices');

//Define Auth Routes
$router->addRoute('POST', 'login', 'AuthController@login');
$router->addRoute('GET', 'logout', 'AuthController@logout');


//Define User Routes
$router->addRoute('GET', 'profile', 'UserController@index');
$router->addRoute('POST', 'updateProfile', 'UserController@updateProfile');

//Define Admin Routes
$router->addRoute('GET', 'admin', 'AdminController@index');
$router->addRoute('GET', 'admin-users', 'AdminController@users');
$router->addRoute('POST', 'deleteUser', 'AdminController@deleteUser');
$router->addRoute('GET', 'admin-riders', 'AdminController@riders');
$router->addRoute('POST', 'deleteRider', 'AdminController@deleteRider');
$router->addRoute('GET', 'admin-orders', 'AdminController@orders');
$router->addRoute('GET', 'admin-services', 'AdminController@services');
$router->addRoute('POST', 'delete-service', 'AdminController@deleteService');
$router->addRoute('GET', 'admin-prices', 'AdminController@prices');
$router->addRoute('GET', 'admin-subscriptions', 'AdminController@subscriptions');
$router->addRoute('GET', 'admin-feedbacks', 'AdminController@feedbacks');
$router->addRoute('POST', 'admin-addCategory', 'AdminController@addCategory');
$router->addRoute('POST', 'admin-addServices', 'AdminController@addServices');
$router->addRoute('POST', 'delete-price', 'AdminController@deletePrice');
$router->addRoute('POST', 'assign-rider', 'AdminController@assignRider');



//Define Rider Routes
$router->addRoute('GET','rider','RiderController@index');

//Define Pickups Routes
$router->addRoute('POST', 'createPickup','PickupsController@createPickup');
$router->addRoute('GET', 'order','PickupsController@order');
$router->addRoute('POST', 'updatePickupStatus', 'PickupsController@updatePickupStatus');
$router->addRoute('POST', 'pickups/cancelPickupStatus', 'PickupsController@cancelPickupStatus');
