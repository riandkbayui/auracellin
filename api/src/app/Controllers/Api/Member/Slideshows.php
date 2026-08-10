<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Slideshows extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex() {
        try {
            $items = service("Slideshows")->findAll([
                ["select", "photo"],
                ["orderBy", "id", "desc"]
            ]);

            if(!$items) {
                throw new Exception("Slideshow kosong.");
            }

            $items = array_map(function($item){
                $item->photo = base_url($item->photo);
                return $item;
            }, $items);

            return $this->respond(compact("items"));
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage()
            ], 500);
        }
    }

}