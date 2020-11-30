<?php 
namespace App\Controller;

use App\Service\UserService;

class UserController extends BaseController {
    private $userService;
    protected $needLogin = false;
    private $error;

    public function __construct($app) {
        parent::__construct($app);
        $this->userService = new UserService(); 
        $this->error = $this->session->get("error");
    }

    public function index() {
        
        $this->render("public/pages/user/user.php");
    }

    public function submit() {
        
    }
}