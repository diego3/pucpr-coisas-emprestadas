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

    private $id;

    public function __construct($config) {
        $this->server = $_SERVER;
        $this->routes = $config;
        $this->wasControllerMatch = false;
        $this->isRest = false;
    }

    public function execute() {
        $uri = $this->server["REQUEST_URI"];    
        $uri = $this->checkId($uri);

        // match com a rota configurada
        foreach($this->routes as $route => $config) {
            if ($route == $uri) {
                list($className, $methodName) = explode("::", $config);
                $this->controllerClass = "App\\Controller\\".ucfirst($className)."Controller";
                $this->controllerMethod = $methodName;
                $this->wasControllerMatch = true;
                
                if (strpos($route, "/") !== false) {
                    $parts = explode("/", $route);
                    $first = $parts[0];
                    if (strpos($first, "rest") !== false) {
                        $this->isRest = true;
                    }
                }
                break;
            }
        }
    }

    protected function checkId($uri) {
        $parts = explode("/", $uri);
        $last = $parts[count($parts)-1];
        if (!empty($last) && $last > 0) {
            $this->id = (int)$last; 
            $newUri = str_replace("/".$last, "", $uri);
            return $newUri;
        } 
        return $uri;
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

    public function getId() {
        return $this->id;
    }
}