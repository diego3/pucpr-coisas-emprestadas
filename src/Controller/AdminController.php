<?php 
namespace App\Controller;

class AdminController extends BaseController {
    protected $needLogin = false;

    public function index() {

        return "public/pages/admin/admin.php";
    }
}