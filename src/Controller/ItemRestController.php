<?php 
namespace App\Controller;

use App\Service\ItemService;
use App\Model\Item;

class ItemRestController {
    private $service;
    private $session;

    public function __construct($app) {
        $this->session = $app->session;
        $this->service = new ItemService();
    }

    public function findAll() {
        $itens = $this->service->findAll();
        return $itens;
    }

    public function postItem() {
        $item = new Item();
        $item->name = $_POST['name'];
        $item->owner = $_POST['owner'];
        $item->thumb = $_POST['thumb'];

        $newItem = $this->service->insert($item);
        return ["new" => $newItem, "post" => $_POST];
    }
}