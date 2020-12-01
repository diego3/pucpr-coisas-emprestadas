<?php 
namespace App\Controller;

use App\Model\Loan;
use App\Service\LoanService;

class LoanRestController extends BaseRestController {
    private $service;

    public function __construct($app) {
        $this->service = new LoanService();
    }

    public function findAll() {
        $itens = $this->service->findAll();
        $this->sendJson($itens);
    }

    public function findById($id) {
        $this->sendJson($this->service->findById($id));
    }

    public function createLoan() {
        $payload = $this->getRequestPayload();
        $loan = new Loan();
        $loan->id_user = $payload->id_user;
        $loan->id_item = $payload->id_item;

        if (isset($payload->contact) && !empty($payload->contact)) {
            $loan->contact = $payload->contact;
        }

        if (isset($payload->devolution) && !empty($payload->devolution)) {
            $loan->devolution = $payload->devolution;
        }

        $newLoan = $this->service->insert($loan);
        $this->sendJson($newLoan);
    }

    public function registerDevolution() {
        $payload = $this->getRequestPayload();
        $loan = new Loan();
        $loan->id = $payload->id_item;
        $this->sendJson($this->service->registerDevolution($loan));
    }
}