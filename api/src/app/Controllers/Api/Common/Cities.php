<?php

namespace App\Controllers\Api\Common;
use App\Controllers\BaseController;

class Cities extends BaseController {

    public function getIndex(){
        $results = service("AreaCities")->findAll();
        return $this->respond($results);
    }

}
