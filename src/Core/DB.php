<?php
namespace App\Core;

use PDO;
use PDOException;
use ReflectionClass;

class DB {
    private static $pdo;

    public static function getPdoInstance() {
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
        $pdo = self::getPdoInstance();
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    public static function executeQuery($sql, array $params, $object, $fetchOne = false) {
        $statment = self::prepareAndExecute($sql, $params);
        
        $reflect = new ReflectionClass($object);
        return $statment->fetchAll(PDO::FETCH_CLASS, $reflect->getName()); 
    }

    public static function fetchAllArray($sql, array $params) {
        $statment = self::prepareAndExecute($sql, $params);
        
        return $statment->fetchAll(PDO::FETCH_ASSOC); 
    }

    public static function fetchOne($sql, array $params, $object) {
        return current(self::executeQuery($sql, $params, $object, true));
    }

    public static function execute($sql, array $params) {
        $statment = self::prepareAndExecute($sql, $params);
        return $statment->rowCount();
    }

    /**
     * Insere e retorna o ultimo ID inserido
     * Remember, if you use a transaction you should use lastInsertId BEFORE you commit otherwise it will return 0
     */
    public static function executeInsert($sql, array $params) {
        self::prepareAndExecute($sql, $params);
        return self::getPdoInstance()->lastInsertId();
    }
   
}