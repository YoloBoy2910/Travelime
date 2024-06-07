<?php

namespace App;

    class Router {
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method) {
        //Look parts between curly brackets and replace them with a dynamic capture group.
        if(preg_match("/\{(\w+)\}/", $route, $matches)) {
            $param = $matches[1];
            $route = preg_replace('/{[^\/]+}/', "(?<{$param}>[^/]+)", $route);
            $route = addcslashes($route, "/");
        }
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action, 'name' => $route];
    } 

    public function get($route, $controller, $action) {
        $this->addRoute($route, $controller, $action, 'GET');
    }

    public function post($route, $controller, $action) {
        $this->addRoute($route, $controller, $action, 'POST');
    }

    public function dispatch() {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        if(array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } else {
            throw new \Exception("No route found for uri: $uri");
        }
    }
}
    

