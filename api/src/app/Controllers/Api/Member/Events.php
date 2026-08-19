<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Events extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex(){
        try {
    		$tbl = "events";
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$getTotal = service("Events")->findOne(array_merge($params, [
				["selectCount", "{$tbl}.id", "total"]
			]));


			$params[] = ["orderBy", "{$tbl}.id", "desc"];
			$params[] = ["select", ["{$tbl}.photo", "{$tbl}.name", "{$tbl}.description"]];
			$params[] = ["limit", $limit, $offset];
			$results = service("Events")->findAll($params);

			if(!$results) {
				throw new Exception("Data kosong!");
			}

            $results = array_map(function($item){
                $item->photo = base_url($item->photo);
                return $item;
            }, $results);

			$hasNext = ($offset + count($results)) < $getTotal->total;

			return $this->respond([
				"limit" => $limit,
				"page" => $page,
				"results" => nestArray($results),
				"total" => $getTotal->total,
				"has_next" => $hasNext
			]);
		} catch (\Throwable $th) {
			return $this->respond([
				"message" => $th->getMessage(),
				"trace" => $th->getTrace()
			], 500);
		}
    }

}