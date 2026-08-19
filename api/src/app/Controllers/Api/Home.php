<?php

namespace App\Controllers\Api;
use App\Controllers\BaseController;
use Exception;

class Home  extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex() {
    	return $this->respond([
            "message" => "Online !"
        ]);
    }

}