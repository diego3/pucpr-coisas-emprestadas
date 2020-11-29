<?php 
namespace App\Service;

use App\Core\DB;
use App\Model\User;

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

    public function insert($user) {
        $params = [
            "name" => $user->getName(),
            "password" => $user->getPassword(),
            "email" => $user->getEmail(),
            "active" => $user->isActive()
        ];
        return DB::execute("INSERT INTO user (name, password, email, active) 
        VALUES (:name, :password, :email, :active)", $params);
    }

    public function update($user) {
        $params = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "password" => $user->getPassword(),
            "email" => $user->getEmail(),
            "active" => $user->isActive()
        ];
        return DB::execute("UPDATE user SET name = :name,
                            password = :password, 
                            email = :email,
                            active = :active 
        WHERE id = :id", $params);
    }
}