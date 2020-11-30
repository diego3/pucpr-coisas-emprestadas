<?php 
namespace App\Controller;

class LoanController extends BaseController {
    protected $needLogin = false;
    public $id;

    public function __construct($app) {
        parent::__construct($app);
    }

    public function index($id) {
        $this->id = $id;
        $this->render("public/pages/loan/loan.php");
    }
}