<?php 
namespace App\Model;

class Loan {
    /**
     * The loaned item
     */
    public $id_item;
    /**
     * Who loan the item
     */
    public $id_user;
    /**
     * When the item was loaned
     * @var Datetime
     */
    public $loan_at;
    /**
     * When the user WILL devolve the loan item
     * @var Date
     */
    public $devolution;
    /**
     * When the user bring back the loan item
     * @var Datetime
     */
    public $devolution_at;

    public $contact;
}