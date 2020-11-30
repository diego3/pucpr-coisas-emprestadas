<?php 
namespace App\Controller;

use App\Service\UserService;

class LoginController extends BaseController {
    private $userService;
    protected $needLogin = false;
    private $error;

    public function __construct($app) {
        parent::__construct($app);
        $this->userService = new UserService(); 
        $this->error = $this->session->get("loginError");
    }

    public function index() {
        
        $this->render("public/pages/login/login.php");
    }

    public function submit() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = current($this->userService->findByEmailAndPassword($email, $password));
        if (empty($user)) {
            $this->session->add("loginError", true);
            $this->redirect("/login");
        }
        
        $this->session->add("user", $user);
        $this->session->add("loginError", false);
        
        if ($user->role == "ADMIN") {
           $this->redirect("/admin");
        } 

        $this->redirect("/home");
    }

    public function logout() {
        $this->session->close();
        $this->redirect("/login");
    }
}