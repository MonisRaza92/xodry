<?php

namespace Core;

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $action)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => trim($path, '/'),
            'action' => $action
        ];
    }

    public function dispatch($requestMethod, $requestPath)
    {
        $requestPath = trim($requestPath, '/');
        $requestPath = $requestPath === '' ? '/' : $requestPath;

        foreach ($this->routes as $route) {
            $routePath = trim($route['path'], '/');
            $routePath = $routePath === '' ? '/' : $routePath;

            if ($route['method'] === strtoupper($requestMethod) && $routePath === $requestPath) {
                list($controllerName, $methodName) = explode('@', $route['action']);
                $controllerClass = "App\\Controllers\\$controllerName";

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $methodName)) {
                        return $controller->$methodName();
                    }
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
