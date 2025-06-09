<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/Router.php';

use Core\Router;

$router = new Router();

// Pass to global for routes.php
global $router;
require_once __DIR__ . '/../routes/routes.php';

// Clean URI
$basePath = '/websites/Xodry/'; // 🔁 Change as per your localhost folder
$requestUri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
$requestUri = trim(parse_url($requestUri, PHP_URL_PATH), '/');
$requestUri = $requestUri === '' ? '/' : $requestUri;

$requestMethod = $_SERVER['REQUEST_METHOD'];

// Debug print
// echo "URI: $requestUri | METHOD: $requestMethod<br>";

$router->dispatch($requestMethod, $requestUri);
