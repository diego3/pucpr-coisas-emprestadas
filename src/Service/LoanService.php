<?php 
namespace App\Service;
use App\Core\DB;
use App\Model\Item;
use App\Model\Loan;
use App\Model\User;

class LoanService {
    private $itemService;
    private $userService;

    public function __construct(){
        $this->itemService = new ItemService();
        $this->userService = new UserService();    
    }

    public function findAll($limit = 100, $page = 0) {
        $sql = "SELECT * FROM loan ";
        
        return DB::executeQuery($sql, [], new Loan());
    }

    public function findById($id) {
        $sql = "SELECT * FROM loan WHERE id = :id";
        
        return DB::fetchOne($sql, ["id" => $id], new Loan());
    }

    /**
     * Cria um novo empréstimo
     */
    public function insert($loan) {
        $params = [
           "id_item" => $loan->id_item,
           "id_user" => $loan->id_user,
           "contact" => $loan->contact
        ];

        if (empty($loan->devolution)) {
            return DB::executeInsert("INSERT INTO loan (id_user, id_item, loanAt, contact) 
            VALUES (:id_user, :id_item, now(), :contact)", $params);
        } else {
            $params["devolution"] = $this->convertDateToMyslFormat($loan->devolution);//DATE
            return DB::executeInsert("INSERT INTO loan (id_user, id_item, loanAt, devolution) 
            VALUES (:id_user, :id_item, now(), :contact, :devolution)", $params);
        }
    }
    
    /**
     * @return string
     */
    private function convertDateToMyslFormat($date) {
        $parts = explode("/", $date);
        if (empty($parts)) {
            return null;
        }
        return $parts[2]."-".$parts[1]."-".$parts[0];
    }

    public function registerDevolution($loan) {
        $params = [
            "id" => $loan->id
        ];    

        return DB::execute("UPDATE loan SET devolvedAt = now() WHERE id = :id", $params, new Loan());
    }
}