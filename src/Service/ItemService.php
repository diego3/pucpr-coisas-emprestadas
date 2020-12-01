<?php 
namespace App\Service;

use App\Core\DB;
use App\Model\Item;

class ItemService {
    
    public function findAll($limit = 100, $page = 0) {
        $sql = "SELECT * FROM item ";
        
        return DB::executeQuery($sql, [], new Item());
    }

    public function findAllForHomePage() {
        $sql = "SELECT 
                    i.id,
                    i.name,
                    i.owner,
                    i.thumb,
                    IF (l.id IS NOT NULL, 1, 0) as emprestado,
                    l.loanAt,
                    l.devolution,
                    IF(l.devolution is null, 1, 0) as semDevolucao,
                    datediff(l.devolution, now()) as entregaEm,
                    IF (datediff(l.devolution, now()) < 0 AND l.devolvedAt is null, 1, 0) as entregaAtrasada,
                    IF(l.devolvedAt is not null, 1, 0) as devolvido,
                    l.contact
                FROM item i
                LEFT JOIN loan l ON l.id = (
                    SELECT a.id FROM loan a WHERE a.id_item = i.id ORDER BY loanAt DESC LIMIT 1
                ) ";
        
        return DB::fetchAllArray($sql, []);
    }

    public function findById($id) {
        $sql = "SELECT * FROM item WHERE id = :id";
        
        return DB::fetchOne($sql, ["id" => $id], new Item());
    }

    public function insert($item) {
        $params = [
           "name" => $item->name,
           "owner" => $item->owner,
           "thumb" => $item->thumb
        ];
        return DB::execute("INSERT INTO item (name, owner, thumb) 
        VALUES (:name, :owner, :thumb)", $params);
    }
}