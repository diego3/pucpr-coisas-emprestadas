<?php 
namespace App\Controller;

use App\Service\ItemService;
use App\Model\Item;

class ItemRestController extends BaseRestController {
    private $service;

    public function __construct($app) {
        $this->service = new ItemService();
    }

    public function findAll() {
        $itens = $this->service->findAll();
        $this->sendJson($itens);
    }
    
    public function findAllForHomePage() {
        $itens = $this->service->findAllForHomePage();
        $this->sendJson($itens);
    }

    public function createItem() {
        $payload = $this->getRequestPayload();
        $item = new Item();
        $item->name = $payload->name;
        $item->owner = 1;//$payload->owner;
        $item->thumb = $payload->thumb;

        $newItem = $this->service->insert($item);
        $this->sendJson($newItem);
    }
}