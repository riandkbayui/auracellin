<?php

namespace App\Controllers\Api;
use App\Controllers\BaseController;
use Exception;

class Ref extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex($username) {
        $username = alphanumeric($username);
        $user = new \stdClass();
        if($username == "admin") {
            $user = service("Users")->findOne([
                ["select", ["name", "username", "phone", "photo", "id"]],
                ["where", "id", "1"]
            ]);
        } else {
            $user = service("Users")->findOne([
                ["select", ["name", "username", "phone", "photo", "id"]],
                ["where", "username", $username]
            ]);
        }
        if($user) {
            $lps = service("LandingPages")->findAll([
                ["where", "user_id", "1"]
            ]);
            $pages = [];
            foreach ($lps as $key => $lp) {
                if(strpos($lp->page_code,"photo")) {
                    $lp->page_content = base_url($lp->page_content);
                }
                $pages[$lp->page_code] = $lp->page_content;
            }
            unset($user->id);
            $user->phone = phoneId($user->phone);
            $user->photo = base_url($user->photo);
            return $this->respond(compact("pages", "user"));
        } else {
            return $this->respond([
                "message" => "Data pengguna tidak ditemukan!"
            ], 404);
        }
    }

}