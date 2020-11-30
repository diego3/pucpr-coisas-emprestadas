<?php 
namespace App\Controller;

class AdminController extends BaseController {
    protected $needLogin = false;

    public function index() {

        $this->render("public/pages/admin/admin.php");
    }
}