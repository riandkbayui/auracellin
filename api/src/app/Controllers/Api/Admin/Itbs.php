<?php

namespace App\Controllers\Api\Admin;
use App\Controllers\BaseController;
use Exception;

class Itbs  extends BaseController {

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

			$getTotal = service("Itbs")->findOne(array_merge($params, [
				["selectCount", "itbs.id", "total"]
			]));

			$params[] = ["orderBy", "itbs.id", "desc"];
			$params[] = ["select", ["itbs.id", "itbs.name", "itbs.phone", "itbs.description"]];
			$params[] = ["select", ["users.username"]];
			$params[] = ["join", "users", "users.id=itbs.user_id", "left"];
			$params[] = ["limit", $limit, $offset];
			$results = service("Itbs")->findAll($params);

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

	public function getEdit($id){
		try {
			$id = numeric($id);
			$form = service("Itbs")->findOne([
				["select", ["id", "name", "phone", "description", "user_id"]],
				["where", "id", $id]
			]);

			if(!$form) {
				throw new Exception("ITB tidak ditemukan!");
			}

			$user = new \stdClass();

			if($form->user_id) {
				$user = service("Users")->findOne([
					["select", ["username"]],
					["where", "id", $form->user_id]
				]);
			}
			
			return $this->respond(compact("form", "user"));
		} catch (\Throwable $th) {
			return $this->respond([
				"message" => $th->getMessage()
			], 500);
		}
	}

	public function postAdd(){
		$rules = [
			"name" => ["label"=> "nama", "rules"=>"required"],
			"phone" => ["label"=> "nomor telepon", "rules"=>"required"],
		];
		
		try {
			if ($this->validate($rules)) {
				$obj = new \stdClass();
				$obj->name = $this->request->getPost("name");
				$obj->phone = $this->request->getPost("phone");
				$obj->phone = phoneId($obj->phone);
				$obj->user_id = $this->request->getPost("user_id");
				$obj->description = $this->request->getPost("description");
				$id = service("Itbs")->create($obj);
				return $this->response->setJSON([
					"message" => "Data ditambahkan!",
					"redirect_to" => "admin/itb/clients/{$id}"
				]);
			} else {
				return $this->response->setStatusCode(400)->setJSON([
					"message" => lang("Validation.invalid"),
					"errors" => $this->validator->getErrors()
				]);
			}
			
		} catch (Exception $e) {
			return $this->response->setStatusCode(500)->setJSON([
				"message" => $e->getMessage()
			]);
		}
	}

	public function postEdit($id){
		$rules = [
			"name" => ["label"=> "nama", "rules"=>"required"],
			"phone" => ["label"=> "nomor telepon", "rules"=>"required"],
		];
		
		try {
			if ($this->validate($rules)) {
				$id = numeric($id);
				$itb = service("Itbs")->findOne([
					["where", "id", $id]
				]);

				if(!$itb) {
					throw new Exception("ITB Tidak Ditemukan!");
				}

				$obj = new \stdClass();
				$obj->name = $this->request->getPost("name");
				$obj->phone = $this->request->getPost("phone");
				$obj->phone = phoneId($obj->phone);
				$obj->user_id = $this->request->getPost("user_id");
				$obj->description = $this->request->getPost("description");
				service("Itbs")->update($id, $obj);
				return $this->response->setJSON([
					"message" => "Data diperbarui!",
					"redirect_to" => "admin/itb/clients/{$id}"
				]);
			} else {
				return $this->response->setStatusCode(400)->setJSON([
					"message" => lang("Validation.invalid"),
					"errors" => $this->validator->getErrors()
				]);
			}
			
		} catch (Exception $e) {
			return $this->response->setStatusCode(500)->setJSON([
				"message" => $e->getMessage()
			]);
		}
	}

	public function getClients($id){
		try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$id = numeric($id);
			$params[] = ["where", "itbs.id", $id];
			$params[] = ["join", "itbs", "itbs.id=itb_clients.itb_id"];

			$getTotal = service("ItbClients")->findOne(array_merge($params, [
				["selectCount", "itb_clients.id", "total"]
			]));

			$params[] = ["orderBy", "itb_clients.id", "desc"];
			$params[] = ["select", ["itb_clients.id", "itb_clients.name", "itb_clients.phone", "itb_clients.itb_id", "area_cities.name as city"]];
			$params[] = ["join", "area_cities", "area_cities.id=itb_clients.city_id"];
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

	public function postClient_add($itb_id){
		$rules = [
			"name" => ["label"=> "name", "rules"=>"required"],
			"phone" => ["label"=> "phone", "rules"=>"required"],
			"city_id" => ["label"=> "kota", "rules"=>"required"],
		];
		
		try {
			if ($this->validate($rules)) {
				$itb_id = numeric($itb_id);
				$itb = service("Itbs")->findOne([
					["where", "id", $itb_id]
				]);
				if(!$itb) {
					throw new Exception("ITB Tidak ditemukan!");
				}
				$obj = new \stdClass();
				$obj->name = $this->request->getPost("name");
				$obj->phone = $this->request->getPost("phone");
				$obj->phone = phoneId($obj->phone);
				$obj->city_id = $this->request->getPost("city_id");
				$obj->is_notified = 0;
				$obj->itb_id = $itb->id;
				$db = db_connect();
				$db->transStart();
				$id = service("ItbClients")->create($obj);

				if($itb->user_id) {
					$user = service("Users")->findOne([
						["where", "id", $itb->user_id]
					]);
					$city = service("AreaCities")->findOne([
						["where", "id",$obj->city_id]
					]);
					service("Whatsapp")->send_message("prospect", $user->phone, [
						"name" => $user->name,
						"username" => $user->username,
						"prospect_name" => $obj->name,
						"prospect_phone" => $obj->phone,
						"prospect_city" => $city->name,
					]);
				}
				
				$db->transComplete();
				return $this->response->setJSON([
					"message" => "Client ditambahkan!",
					"redirect_to" => "/admin/itbs/clients/edit/{$itb->id}/{$id}"
				]);
			} else {
				return $this->response->setStatusCode(400)->setJSON([
					"message" => lang("Validation.invalid"),
					"errors" => $this->validator->getErrors()
				]);
			}
			
		} catch (Exception $e) {
			return $this->response->setStatusCode(500)->setJSON([
				"message" => $e->getMessage()
			]);
		}
	}

	public function getClient_edit($itb_id, $id){
	    try {
	    	$id = numeric($id);
	    	$itb_id = numeric($itb_id);
	    	$params = [];
	    	$params[] = ["select", ["itb_clients.name" ,"itbs.name as itb_name", "itbs.phone as itb_phone", "itb_clients.phone", "itb_clients.is_notified", "itb_clients.city_id", "area_cities.name as city_name"]];
			$params[] = ["join", "itbs", "itbs.id=itb_clients.itb_id"];
			$params[] = ["join", "area_cities", "area_cities.id=itb_clients.city_id"];
			$params[] = ["where", "itbs.id", $itb_id];
			$params[] = ["where", "itb_clients.id", $id];
			$form = service("ItbClients")->findOne($params);
			if(!$form) {
				throw new Exception("Form tidak ditemukan!");
			}
			return $this->respond(compact("form"));
	    } catch (\Throwable $th) {	    	
	    	return $this->respond([
	    		"message" => $th->getMessage()
	    	], 500);
	    }
	}

	public function postClient_edit($itb_id, $id){
		$rules = [
			"name" => ["label"=> "name", "rules"=>"required"],
			"phone" => ["label"=> "phone", "rules"=>"required"],
			"city_id" => ["label"=> "kota", "rules"=>"required"],
			"is_notified" => ["label"=> "notifikasi", "rules"=>"required"],
		];
		
		try {
			if ($this->validate($rules)) {
				$itb_id = numeric($itb_id);
				$itb = service("Itbs")->findOne([
					["where", "id", $itb_id]
				]);
				if(!$itb) {
					throw new Exception("ITB Tidak ditemukan!");
				}
				$id = numeric($id);
				$client = service("ItbClients")->findOne([
					["where", "id", $id]
				]);
				if(!$client) {
					throw new Exception("Client Tidak ditemukan!");
				}
				$obj = new \stdClass();
				$obj->name = $this->request->getPost("name");
				$obj->phone = $this->request->getPost("phone");
				$obj->phone = phoneId($obj->phone);
				$obj->city_id = $this->request->getPost("city_id");
				$obj->is_notified = $this->request->getPost("is_notified");

				$id = service("ItbClients")->update($client->id, $obj);
				return $this->response->setJSON([
					"message" => "Client diperbarui!",
					"redirect_to" => "/admin/itbs/clients/{$itb->id}"
				]);
			} else {
				return $this->response->setStatusCode(400)->setJSON([
					"message" => lang("Validation.invalid"),
					"errors" => $this->validator->getErrors()
				]);
			}
			
		} catch (Exception $e) {
			return $this->response->setStatusCode(500)->setJSON([
				"message" => $e->getMessage()
			]);
		}
	}

}