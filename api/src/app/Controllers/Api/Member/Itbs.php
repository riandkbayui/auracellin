<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Itbs  extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex() {
    	try {
    		$tbl = "itb_clients";
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$user_id = userId();
			$params[] = ["where", "itbs.user_id", $user_id];
			$params[] = ["join", "itbs", "itbs.id={$tbl}.itb_id"];

			$getTotal = service("ItbClients")->findOne(array_merge($params, [
				["selectCount", "{$tbl}.id", "total"]
			]));

			$params[] = ["join", "area_cities", "area_cities.id={$tbl}.city_id"];

			$params[] = ["orderBy", "{$tbl}.id", "desc"];
			$params[] = ["select", ["{$tbl}.name", "area_cities.name as city", "{$tbl}.phone"]];
			$params[] = ["limit", $limit, $offset];
			$results = service("ItbClients")->findAll($params);

			if(!$results) {
				throw new Exception("Data kosong!");
			}

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