<?php

namespace App;

class Router
{
    public $routes = [];

    private function addRoute($route, $controller, $action, $method)
    {
        //Look parts between curly brackets and replace them with a dynamic capture group.
        if (preg_match("/\{(\w+)\}/", $route, $matches)) {
            $param = $matches[1];
            $route = preg_replace('/{[^\/]+}/', "(?<{$param}>[^/]+)", $route);
            $route = addcslashes($route, "/");
            $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
        } else {
            $route = addcslashes($route, "/");
            $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
        }
    }

    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'GET');
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'POST');
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (array_keys($this->routes[$method]) as $route) {
            if (preg_match("#^" . $route . "$#", $uri, $matches)) {
                $controller = $this->routes[$method][$route]['controller'];
                $action = $this->routes[$method][$route]['action'];
                $Controller = new $controller();

                if (sizeof($matches) > 1) {
                    $arg = $matches[1];
                    call_user_func([$Controller, $action], $arg);
                } else {
                    $Controller->$action();
                }
                return;
            }
        }
        throw new \Exception("Error couldn't find route for: $uri");
    }
}
