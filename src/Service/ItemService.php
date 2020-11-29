<?php 
namespace App\Service;

use App\Core\DB;
use App\Model\Item;

class ItemService {
    
    public function findAll($limit = 100, $page = 0) {
        $sql = "SELECT * FROM item ";
        
        return DB::executeQuery($sql, [], new Item());
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