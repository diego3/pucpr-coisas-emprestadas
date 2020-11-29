<?php 
namespace App\Core;

use ReflectionClass;
use ReflectionMethod;

class Router {
    private $server;
    /**
     * @var array
     */
    private $routes;

    private $isRest;

    private $controllerClass;

    private $controllerMethod;

    private $wasControllerMatch;

    public function __construct($config) {
        $this->server = $_SERVER;
        $this->routes = $config;
        $this->wasControllerMatch = false;
        $this->isRest = false;
    }

    public function execute() {
        // parse do uri
        //$parse = parse_url($uri);

        $uri = $this->server["REQUEST_URI"];    
        
        // match com a rota configurada
        foreach($this->routes as $route => $config) {
            if ($route == $uri) {
                list($className, $methodName) = explode("::", $config);
                $this->controllerClass = "App\\Controller\\".ucfirst($className)."Controller";
                $this->controllerMethod = $methodName;
                $this->wasControllerMatch = true;

                if (strpos($route, "rest") !== false) {
                    $this->isRest = true;
                }
                break;
            }
        }
    }

    public function getControllerClass() {
        return $this->controllerClass;
    }

    public function getControllerMethod() {
        return $this->controllerMethod;
    }

    /**
     * @return bool
     */
    public function wasControllerMatch() {
        return $this->wasControllerMatch;
    }

    public function isRest() {
        return $this->isRest;
    }
}