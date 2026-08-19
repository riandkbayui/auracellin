<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Dashboard extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex() {
        try {
            $obj = new \stdClass();
            $obj->users = service("Users")->findOne([
                ["selectCount", "id", "total"]
            ])->total ?? 0;
            $obj->users = sprintf("%04d", $obj->users);
            
            $obj->studyrooms = service("StudyRooms")->findOne([
                ["selectCount", "id", "total"]
            ])->total ?? 0;
            $obj->studyrooms = sprintf("%03d", $obj->studyrooms);

            $obj->missions = service("Missions")->findOne([
                ["selectCount", "id", "total"]
            ])->total ?? 0;
            $obj->missions = sprintf("%03d", $obj->missions);
        } catch (\Throwable $th) {
            $obj->users = 0;
            $obj->studyrooms = 0;
            $obj->missions = 0;
        }

        return $this->respond([
            "count" => $obj
        ]);
    }

}