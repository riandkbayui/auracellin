<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Forms  extends BaseController {

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

			$user_id = userId();
			$params[] = ["where", "forms.user_id", $user_id];

			$getTotal = service("Forms")->findOne(array_merge($params, [
				["selectCount", "forms.id", "total"]
			]));

			$params[] = ["orderBy", "forms.id", "desc"];
			$params[] = ["select", ["forms.id", "forms.name", "forms.status"]];
			$params[] = ["limit", $limit, $offset];
			$results = service("Forms")->findAll($params);

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

	public function postAdd() {
		$rules = [
			"name" => ["label"=> "id", "rules"=>"required"],
			"slug" => ["label"=> "id", "rules"=>"required"],
			"text_start" => ["label"=> "id", "rules"=>"required"],
			"fields" => ["label"=> "id", "rules"=>"required"],
			"phones" => ["label"=> "id", "rules"=>"required"],
			"status" => ["label"=> "id", "rules"=>"required|in_list[active,inactive]"],
		];
		
		try {
			if ($this->validate($rules)) {
				$data = new \stdClass();
				$data->slug = $this->request->getPost("slug");
				$data->slug = slugify($data->slug);
				$data->name = $this->request->getPost("name");
				$data->text_start = $this->request->getPost("text_start");
				$data->text_end = $this->request->getPost("text_end");
				$data->fields = $this->request->getPost("fields");
				$data->fields = json_encode($data->fields);
				$data->phones = $this->request->getPost("phones");
				$data->status = $this->request->getPost("status");
				$data->user_id = user("id");
				$data->phones = preg_replace('/[^0-9;]+/', '', $data->phones);
				foreach (explode(";", $data->phones) as $phone) {
					if(substr($phone, 0, 2) != "62") {
						throw new Exception("Pastikan nomor telepon diawali dengan kode 62");
					}
				}
				
				$slugCheck = service("Forms")->findOne([
					["where", "slug", $data->slug]
				]);

				if($slugCheck) {
					throw new Exception("Link sudah pernah digunakan!");
				}

				service("Forms")->create($data);
				return $this->response->setJSON([
					"message" => "Formulir ditambahkan!",
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

	public function getEdit($id){
	    try {
	    	$user_id = user("id");
	    	$id = numeric($id);

	    	$form = service("Forms")->findOne([
	    		["select", ["id", "name", "slug", "text_start", "text_end", "fields", "phones", "status"]],
	    		["where", "user_id", $user_id],
	    		["where", "id", $id]
	    	]);

	    	if(!$form) {
	    		throw new Exception("Form tidak ditemukan!");
	    	}

	    	$form->fields = json_decode($form->fields);

	    	return $this->respond(compact("form"));
	    } catch (\Throwable $th) {
	    	return $this->respond([
	    		"message" => $th->getMessage()
	    	], 500);
	    }
	}

	public function postEdit($id) {
		$rules = [
			"name" => ["label"=> "id", "rules"=>"required"],
			"slug" => ["label"=> "id", "rules"=>"required"],
			"text_start" => ["label"=> "id", "rules"=>"required"],
			"fields" => ["label"=> "id", "rules"=>"required"],
			"phones" => ["label"=> "id", "rules"=>"required"],
			"status" => ["label"=> "id", "rules"=>"required|in_list[active,inactive]"],
		];
		
		try {
			if ($this->validate($rules)) {
				$id = numeric($id);

				$form = service("Forms")->findOne([
					["where", "id", $id],
					["where", "user_id", user("id")]
				]);

				if(!$form) {
					throw new Exception("Form tidak ditemukan!");
				}

				$data = new \stdClass();
				$data->slug = $this->request->getPost("slug");
				$data->slug = slugify($data->slug);
				$data->name = $this->request->getPost("name");
				$data->text_start = $this->request->getPost("text_start");
				$data->text_end = $this->request->getPost("text_end");
				$data->fields = $this->request->getPost("fields");
				$data->fields = json_encode($data->fields);
				$data->phones = $this->request->getPost("phones");
				$data->status = $this->request->getPost("status");
				
				foreach (explode(";", $data->phones) as $phone) {
					if(substr($phone, 0, 2) != "62") {
						throw new Exception("Pastikan nomor telepon diawali dengan kode 62");
					}
				}
				
				$slugCheck = service("Forms")->findOne([
					["where", "slug", $data->slug],
					["where", "id !=", $form->id]
				]);

				if($slugCheck) {
					throw new Exception("Link sudah pernah digunakan!");
				}
				
				service("Forms")->update($form->id, $data);
				return $this->response->setJSON([
					"message" => "Formulir diperbarui!",
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