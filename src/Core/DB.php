<?php
namespace App\Core;

use PDO;
use PDOException;
use ReflectionClass;

class DB {
    private static $pdo;

    public static function getInstance() {
        if (self::$pdo == null) {
            try {
                self::$pdo = new PDO("mysql:dbname=coisas_emprestadas;host=127.0.0.1;charset=utf8mb4", "root", "root");
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'erro PDO: '.$e->getMessage();
            }
        }
        return self::$pdo;
    }

    private static function prepareAndExecute($sql, array $params) {
        $pdo = self::getInstance();
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    public static function executeQuery($sql, array $params, $object) {
        $statment = self::prepareAndExecute($sql, $params);
        
        $reflect = new ReflectionClass($object);
        return $statment->fetchAll(PDO::FETCH_CLASS, $reflect->getName()); 
    }

    public static function execute($sql, array $params) {
        $statment = self::prepareAndExecute($sql, $params);
        return $statment->rowCount();
    }
}