<?php 
namespace App\Controller;

class HomeController extends BaseController {
    protected $needLogin = true;
    public $userId;

    public function index() {
        $this->userId = $this->getLoggedUser()->id;

        $this->render("public/pages/home/home.php");
    }

}