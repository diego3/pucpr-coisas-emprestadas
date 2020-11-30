<?php 
namespace App\Controller;

abstract class BaseController {
    protected $application;
    protected $session;
    protected $needLogin = true;
    protected $loggedUser;

    public function __construct($app) {
        $this->application = $app;
        $this->session = $app->session;
        $this->loggedUser = $this->session->get("user");
        if ($this->needLogin && empty($this->loggedUser)) {
            header("Location: /login");
        }
    }

    protected function redirect($page) {
        header("Location: ".$page);
        exit;
    }

    protected function render($view) {
        require $view;
    }
}