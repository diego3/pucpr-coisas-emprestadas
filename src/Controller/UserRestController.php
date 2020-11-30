<?php 
namespace App\Controller;

use App\Model\User;
use App\Service\UserService;

class UserRestController extends BaseRestController {
    private $service;

    public function __construct($app) {
        $this->service = new UserService();
    }

    public function findAll() {
        $itens = $this->service->findAll();
        $this->sendJson($itens);
    }

    public function findById($id) {
        $user = $this->service->findById($id);
        $status = 200;
        if (empty($user)) {
            $status = 404;
        }
        $this->sendJson($user, $status);
    }

    public function createUser() {
        $payload = $this->getRequestPayload();
        $user = new User();
        $user->name = $payload->name;
        $user->email = $payload->email;
        $user->password = $payload->password;
        if (isset($payload->role) && !empty($payload->role)) {
            $user->role = $payload->role;
        }

        $newUser = $this->service->insert($user);
        $this->sendJson($newUser, 201);
    }

    public function updateUser() {
        $payload = $this->getRequestPayload();
        $user = $this->service->findById($payload->id);
        if (empty($user)) {
            $this->sendJson(["msg" => "usuario não encontrado"], 404);
            exit;
        }
        
        $user->name = $payload->name;
        $user->email = $payload->email;
        $user->password = $payload->password;
        if (isset($payload->role) && !empty($payload->role)) {
            $user->role = $payload->role;
        }

        $count = $this->service->update($user);
        
        if ($count > 0) {
            $this->sendJson(["msg" => "Atualizado com sucesso"], 200);
        } else {
            $this->sendJson(["msg" => "erro"], 400);
        }
    }
}