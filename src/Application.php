<?php 
namespace App;
use App\Core\Router;
use App\Core\Session;
use App\Service\UserService;

class Application {
    public $router;
    public $session;

    public function __construct(array $config) {
        $this->router = new Router($config["router"]);
        $this->session = new Session();    
    }

    public function start() {
        $this->router->execute();
        if (!$this->router->isRest()) {
            $this->session->start();
        }

        if (!$this->router->wasControllerMatch()) {
            header("Content-Type: application/json");
            http_response_code(404);
            echo json_encode(["erro 404" => "rota não encontrada"]);
            exit;    
        }

        $class = $this->router->getControllerClass();
        $methodName = $this->router->getControllerMethod();
        $controller = new $class($this);
        $controller->$methodName($this->router->getId());
    }

}