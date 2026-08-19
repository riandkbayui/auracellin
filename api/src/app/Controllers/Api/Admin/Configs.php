<?php

namespace App\Controllers\Api\Admin;
use App\Controllers\BaseController;
use Exception;

class Configs  extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

	public function getIndex(){
		try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$getTotal = service("Configs")->findOne(array_merge($params, [
				["selectCount", "configs.id", "total"]
			]));

			$params[] = ["orderBy", "configs.description", "asc"];
			$params[] = ["select", ["configs.id", "configs.description", "configs.value"]];
			$params[] = ["limit", $limit, $offset];
			$results = service("Configs")->findAll($params);

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

    public function postUpdate(){
        try {
			$id = $this->request->getPost('id');
			$value = $this->request->getPost('value');
			service("Configs")->update([
				["where", "id", $id]
			], ["value" => $value]);
			return $this->response->setStatusCode(200)->setJSON(["message" => lang('App.updated', ['Konfigurasi'])]);
		} catch (Exception $e) {
			return $this->response->setStatusCode(500)->setJSON(["message" => $e->getMessage()]);
		}
    }

}