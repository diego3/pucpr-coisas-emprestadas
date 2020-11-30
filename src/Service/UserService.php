<?php 
namespace App\Service;

use App\Core\DB;
use App\Model\User;
use App\Model\Role;

class UserService {

    /**
     * @return User[]
     */
    public function findAll() {
        $sql = "SELECT u.*, UPPER(r.role_name) as role FROM user u
                INNER JOIN user_role ur ON ur.id_user = u.id
                INNER JOIN role r ON r.id = ur.id_role";
        return DB::executeQuery($sql, [], new User());
    }

    /**
     * @return User[]
     */
    public function findByEmailAndPassword($email, $password) {
        $params = [
            "e" => $email,
            "p" => $password
        ];
        $sql = "SELECT u.*, UPPER(r.role_name) as role FROM user u
                INNER JOIN user_role ur ON ur.id_user = u.id
                INNER JOIN role r ON r.id = ur.id_role
                WHERE email = :e AND password = :p";
        return DB::executeQuery($sql, $params, new User());
    }

    /**
     * @return User
     */
    public function findById($id) {
        $params = [
            "id" => $id
        ];
        $sql = "SELECT u.*, UPPER(r.role_name) as role FROM user u
                INNER JOIN user_role ur ON ur.id_user = u.id
                INNER JOIN role r ON r.id = ur.id_role
                WHERE u.id = :id";
        return DB::fetchOne($sql, $params, new User());
    }

    /**
     * Cria um novo usuario
     * @return bool 
     */
    public function insert($user) {
        $params = [
            "name" => $user->name,
            "password" => $user->password,
            "email" => $user->email,
            "active" => 1
        ];
        $userId = DB::executeInsert("INSERT INTO user (name, password, email, active) 
        VALUES (:name, :password, :email, :active)", $params);

        if (empty($userId)) {
            echo 'falhou no insert do usuario';
            return false;
        }
        
        $role = !empty($user->role) ? $user->role : "SIMPLE_CUSTOMER";
        $roleId = null;
        $role = DB::fetchOne("SELECT id FROM role WHERE role_name = :name", ["name" => $user->role], new Role());
        if (!empty($role)) {
            $roleId = $role->id;
        }
        else {
            $roleId = DB::executeInsert("INSERT INTO role (role_name) VALUES (:name)", ["name" => $user->role]);
        }

        DB::executeInsert("INSERT INTO user_role (id_user, id_role) 
                VALUES (:id_user, :id_role)", [
                    "id_user" => $userId,
                    "id_role" => $roleId
                ]);
        
        return $this->findById($userId);
    }

    public function update($user) {
        $params = [
            "id" => $user->id,
            "name" => $user->name,
            "password" => $user->password,
            "email" => $user->email,
            "active" => $user->active
        ];
        return DB::execute("UPDATE user SET name = :name,
                            password = :password, 
                            email = :email,
                            active = :active 
        WHERE id = :id", $params);
    }
}