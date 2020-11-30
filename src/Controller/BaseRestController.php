<?php 
namespace App\Controller;

abstract class BaseRestController {
    protected $application;
    protected $session;

    public function __construct($app) {
        $this->application = $app;
    }

    protected function sendJson($object, $code = 200) {
        header("Content-Type: application/json");
        http_response_code($code);
        echo json_encode($object);
    }

    protected function getRequestPayload() {
        $request_body = file_get_contents('php://input');
        return json_decode($request_body);
    }
}