<?php
class Router {
    public function start() {
        try {
            $uri = $_SERVER["REQUEST_URI"];
            $path = strtok($uri, '?');

            if ($path === "/") {
                $controller = new MainController();
                $controller->index($_GET);
            } else {
                $url = explode("/", trim($path, "/"))[0];
                $controllerName = ucfirst($url) . "Controller";
                
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, "index")) {
                        $controller->index($_GET);
                    } else {
                        throw new Exception("Implémentez la fonction index !!!");
                    }
                } else {
                    require("../views/error.php");
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}