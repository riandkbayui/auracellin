<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Areas extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function postCities_select2() {
        try {
            $search = $this->request->getPost("q");
            $results = service("AreaCities")->findAll([
                ["asArray"],
                ["select", ["id", "name as text"]],
                ["like", "name", $search],
                ["orderBy", "name"],
                ["limit", "25"]
            ]);
            return $this->respond(compact("results"));
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage()
            ], 500);
        }
    }

}