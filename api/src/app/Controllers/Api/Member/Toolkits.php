<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Toolkits extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex($slug) {
        try {
            $slug = alphanumeric($slug);
            $slug = str_replace("-", "_", $slug);
            return view("member/toolkits/{$slug}");
        } catch (\Throwable $th) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($th->getMessage());
        }
    }

}