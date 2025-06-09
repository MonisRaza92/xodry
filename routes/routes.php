<?php

use Core\Router;

global $router;
//Define Home Routes
$router->addRoute('GET', '/', 'HomeController@index');
$router->addRoute('GET', 'home', 'HomeController@index');
$router->addRoute('GET', 'about', 'HomeController@about');
$router->addRoute('GET', 'services', 'HomeController@services');

//Define Auth Routes
$router->addRoute('POST', 'login', 'AuthController@login');
$router->addRoute('GET', 'logout', 'AuthController@logout');


//Define User Routes
$router->addRoute('GET', 'profile', 'UserController@index');
$router->addRoute('POST', 'updateProfile', 'UserController@updateProfile');

//Define Admin Routes
$router->addRoute('GET', 'admin', 'AdminController@index');

//Define Rider Routes
$router->addRoute('GET','rider','RiderController@index');

//Define Pickups Routes
$router->addRoute('POST', 'createPickup','PickupsController@createPickup');
$router->addRoute('GET', 'order','PickupsController@order');
