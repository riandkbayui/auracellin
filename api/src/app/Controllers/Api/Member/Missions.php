<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Missions  extends BaseController {

	private $upload_path = "uploads/missions/";

	public function __construct() {
		parent::__construct();
		//do_nothing
	}

	public function getIndex() {
		try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$user_id = userId();
			$params[] = ["join", "mission_subs","mission_subs.mission_id=missions.id AND mission_subs.user_id={$user_id}", "left"];
			$params[] = ["where", "mission_subs.user_id IS NULL"];

			$getTotal = service("Missions")->findOne(array_merge($params, [
				["selectCount", "missions.id", "total"]
			]));

			$params[] = ["orderBy", "missions.id", "desc"];
			$params[] = ["select", ["missions.code", "missions.name", "missions.description", "missions.created_at"]];
			$params[] = ["select", ["users.name as user__name", "users.username as user__username", "users.photo as user__photo"]];
			$params[] = ["join", "users", "users.id=missions.user_id"];
			$params[] = ["limit", $limit, $offset];
			$results = service("Missions")->findAll($params);

			if(!$results) {
				throw new Exception("Data kosong!");
			}

			$hasNext = ($offset + count($results)) < $getTotal->total;

			$results = array_map(function($obj){
				$obj->user__photo = base_url($obj->user__photo);
				return $obj;
			}, $results);

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

	public function getHistories() {
		try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$user_id = userId();
			$params[] = ["join", "mission_subs","mission_subs.mission_id=missions.id and mission_subs.user_id={$user_id}"];

			$getTotal = service("Missions")->findOne(array_merge($params, [
				["selectCount", "missions.id", "total"]
			]));

			$params[] = ["orderBy", "missions.id", "desc"];
			$params[] = ["select", ["missions.code", "missions.name", "missions.description", "missions.created_at"]];
			$params[] = ["select", ["users.name as user__name", "users.username as user__username", "users.photo as user__photo"]];
			$params[] = ["select", "mission_subs.status"];
			$params[] = ["join", "users", "users.id=missions.user_id"];
			$params[] = ["limit", $limit, $offset];
			$results = service("Missions")->findAll($params);

			if(!$results) {
				throw new Exception("Data kosong!");
			}

			$hasNext = ($offset + count($results)) < $getTotal->total;

			$results = array_map(function($obj){
				$obj->user__photo = base_url($obj->user__photo);
				return $obj;
			}, $results);

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

	public function getParticipants() {
		try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$user_id = userId();
			$params[] = ["join", "mission_subs","mission_subs.mission_id=missions.id"];

			$getTotal = service("Missions")->findOne(array_merge($params, [
				["selectCount", "mission_subs.id", "total"]
			]));

			$params[] = ["orderBy", "mission_subs.id", "desc"];
			$params[] = ["select", ["mission_subs.code", "missions.name", "missions.description", "missions.created_at"]];
			$params[] = ["select", ["users.name as user__name", "users.username as user__username", "users.photo as user__photo"]];
			$params[] = ["select", "mission_subs.status"];
			$params[] = ["join", "users", "users.id=mission_subs.user_id"];
			$params[] = ["where", "missions.user_id", userId()];
			$params[] = ["limit", $limit, $offset];
			$results = service("Missions")->findAll($params);

			if(!$results) {
				throw new Exception("Data kosong!");
			}

			$hasNext = ($offset + count($results)) < $getTotal->total;

			$results = array_map(function($obj){
				$obj->user__photo = base_url($obj->user__photo);
				return $obj;
			}, $results);

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

	public function getMe() {
		try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$user_id = userId();

			$params[] = ["where", "user_id", $user_id];
			$getTotal = service("Missions")->findOne(array_merge($params, [
				["selectCount", "id", "total"]
			]));

			$params[] = ["orderBy", "missions.id", "desc"];
			$params[] = ["select", ["missions.code", "missions.name", "missions.description", "missions.created_at"]];
			$params[] = ["select", ["users.name as user__name", "users.username as user__username", "users.photo as user__photo"]];
			$params[] = ["join", "users", "users.id=missions.user_id"];
			$params[] = ["limit", $limit, $offset];
			$results = service("Missions")->findAll($params);

			if(!$results) {
				throw new Exception("Data kosong!");
			}

			$hasNext = ($offset + count($results)) < $getTotal->total;

			$results = array_map(function($obj){
				$obj->user__photo = base_url($obj->user__photo);
				return $obj;
			}, $results);

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

	public function getOpen($slug){
		try {
			$slug = alphanumeric($slug);
			$mission = service("Missions")->findOne([
				["where", "code", $slug]
			]);

			if(!$mission) {
				throw new Exception(lang("App.notfound", ["Misi"]));
			}

			$user = service("Users")->findOne([
				["select", ["name", "username", "photo"]],
				["where", "id", $mission->user_id]
			]);

			$user->photo = base_url($user->photo);

			$sub = service("MissionSubs")->findOne([
				["select", ["photo", "description", "status"]],
				["where", "mission_id", $mission->id],
				["where", "user_id", userId()]
			]);

			if($sub) {
				$sub->photo = base_url($sub->photo);
			} else {
				$obj = new \stdClass();
				$obj->description = "";
				$obj->photo = base_url("uploads/general/placeholder.jpg");
				$sub = $obj;
			}

			unset_var($mission, "id", "user_id", "created_by", "updated_by", "deleted_by");

			return $this->respond([
				"data" => $mission,
				"user" => $user,
				"sub" => $sub
			]);
		} catch (\Throwable $th) {
			return $this->respond([
				"message" => $th->getMessage(),
				"trace" => $th->getTrace()
			], 500);
		}
	}

	public function getParticipant($slug){
		try {
			$slug = alphanumeric($slug);

			$sub = service("MissionSubs")->findOne([
				["select", ["mission_id", "user_id", "code", "photo", "description", "status"]],
				["where", "code", $slug],
			]);

			if(!$sub) {
				throw new Exception(lang("App.notfound", ["Partisipan"]));
			}

			$mission = service("Missions")->findOne([
				["where", "id", $sub->mission_id]
			]);

			if(!$mission) {
				throw new Exception(lang("App.notfound", ["Misi"]));
			}

			$user = service("Users")->findOne([
				["select", ["name", "username", "photo"]],
				["where", "id", $sub->user_id]
			]);

			$user->photo = base_url($user->photo);
			$sub->photo = base_url($sub->photo);

			unset_var($mission, "id", "user_id", "created_by", "updated_by", "deleted_by");
			unset_var($sub, "mission_id", "user_id");

			return $this->respond([
				"data" => $mission,
				"user" => $user,
				"sub" => $sub
			]);
		} catch (\Throwable $th) {
			return $this->respond([
				"message" => $th->getMessage(),
				"trace" => $th->getTrace()
			], 500);
		}
	}

	public function postParticipant($slug){
	    try {
	    	$type = $this->request->getPost('type');
	    	$type = alphanumeric($type);

	    	if(!in_array($type, ['accept', 'reject'])) {
	    		throw new Exception('Pilihan tidak dikenali!');
	    	}

	    	$sub = service("MissionSubs")->findOne([
	    		["select", "mission_subs.*"],
	    		["join", "missions", "missions.id=mission_subs.mission_id"],
	    		["where", "mission_subs.code", $slug],
	    		["where", "missions.user_id", userId()]
	    	]);

	    	if(!$sub) {
	    		throw new Exception("Misi tidak ditemukan!");
	    	}

	    	$status = $type=="accept" ? "success" : "fail";

	    	service("MissionSubs")->update($sub->id, [
	    		"status" => $status
	    	]);

	    	return $this->respond([
	    		"message" => "Berhasil diperbarui.",
	    		"redirect_to" => "/member/missions/participants"
	    	]);
	    } catch (\Throwable $th) {
	    	return $this->respond([
				"message" => $th->getMessage(),
				"trace" => $th->getTrace()
			], 500);
	    }
	}

	public function postCreate(){
		$rules = [
			"name" => ["label"=> "judul", "rules"=>"required"],
			"description" => ["label"=> "deskripsi", "rules"=>"required"],
			"url" => ["label"=> "link", "rules"=>"required"],
		];
		
		try {
			if ($this->validate($rules)) {
				$obj = new \stdClass();
				$obj->name = $this->request->getPost('name');
				$obj->description = $this->request->getPost('description');
				$obj->url = $this->request->getPost('url');
				$obj->code = str_rand();
				$obj->user_id = userId();
				$obj->created_by = userId();

				service("Missions")->create($obj);
				return $this->response->setJSON([
					"message" => "Berhasil ditambahkan!",
					"redirect_to" => "/member/missions/me"
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

	public function getEdit($slug){
		try {
			$slug = alphanumeric($slug);
			$mission = service("Missions")->findOne([
				["where", "code", $slug],
				["where", "user_id", userId()]
			]);

			if(!$mission) {
				throw new Exception(lang("App.notfound", ["Misi"]));
			}

			$mission = unset_var($mission, "id", "created_by", "updated_by", "deleted_by");

			return $this->respond([
				"form" => $mission
			]);
		} catch (\Throwable $th) {
			return $this->response->setStatusCode(500)->setJSON([
				"message" => $th->getMessage()
			], 500);
		}
	}

	public function postEdit($slug){
		$rules = [
			"name" => ["label"=> "judul", "rules"=>"required"],
			"description" => ["label"=> "deskripsi", "rules"=>"required"],
			"url" => ["label"=> "link", "rules"=>"required"],
		];
		
		try {
			if ($this->validate($rules)) {
				$slug = alphanumeric($slug);
				$obj = service("Missions")->findOne([
					["where", "code", $slug],
					["where", "user_id", userId()]
				]);

				if(!$obj) {
					throw new Exception(lang("App.notfound", ["Misi"]));
				}

				$obj->name = $this->request->getPost('name');
				$obj->description = $this->request->getPost('description');
				$obj->url = $this->request->getPost('url');
				$obj->updated_by = userId();

				service("Missions")->save($obj);
				return $this->response->setJSON([
					"message" => "Berhasil diperbarui!",
					"redirect_to" => "/member/missions/me"
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

	public function postSubmit($slug){
		$rules = [
			"photo" => [ 'label' => 'Image File', 'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'],
			"description" => ["label"=> "deskripsi", "rules"=>"required"],
		];
		
		try {
			if ($this->validate($rules)) {

				$slug = alphanumeric($slug);
				$mission = service("Missions")->findOne([
					["where", "code", $slug]
				]);

				if(!$mission) {
					throw new Exception(lang("App.notfound", ["Misi"]));
				}

				$sub = service("MissionSubs")->findOne([
					["where", "mission_id", $mission->id],
					["where", "user_id", userId()]
				]);

				if($sub) {
					throw new Exception("Tidak dapat submit ulang.");
				}

				$data = new \stdClass();
				$data->description = $this->request->getPost('description');
				$data->user_id = userId();
				$data->mission_id = $mission->id;
				$data->status = 'pending';
				$data->code = str_rand();

				$photo = $this->request->getFile('photo');
				if ($photo && $photo->isValid() && !$photo->hasMoved()) {
					$file_name = upload_img($photo, $this->upload_path, [
						['fit', 960, 540, 'center'],
					]);
					$data->photo = $this->upload_path . $file_name;
				} else {
					throw new Exception("File photo tidak valid!");
				}

				service("MissionSubs")->create($data);

				return $this->response->setJSON([
					"message" => "Berhasil submit!",
					"redirect_to" => "/member/missions"
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

	public function postUpdatesub($slug){
		$rules = [
			"description" => ["label"=> "deskripsi", "rules"=>"required"],
		];
		
		try {
			$photo = $this->request->getFile('photo');
			if ($photo && $photo->isValid() && !$photo->hasMoved()) {
				$rules['photo'] = [ 'label' => 'Image File', 'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'];
			}
			if ($this->validate($rules)) {

				$slug = alphanumeric($slug);
				$mission = service("Missions")->findOne([
					["where", "code", $slug]
				]);

				if(!$mission) {
					throw new Exception(lang("App.notfound", ["Misi"]));
				}

				$data = new \stdClass();
				$data->description = $this->request->getPost('description');

				
				if ($photo && $photo->isValid() && !$photo->hasMoved()) {
					$file_name = upload_img($photo, $this->upload_path, [
						['fit', 960, 540, 'center'],
					]);

					if($file_name) {
						$data->photo = $this->upload_path . $file_name;
					}
				}

				service("MissionSubs")->update([
					["where", "mission_id", $mission->id],
					["where", "user_id", userId()],
				], $data);

				return $this->response->setJSON([
					"message" => "Berhasil diperbarui!",
					"redirect_to" => "/member/missions"
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

	public function getCard(){
	    try {
	    	$user_id = userId();

	    	$sub = service("Missions")->findOne([
				["select", "COUNT(missions.id) as total", false],
	    		["select", "COUNT(IF(mission_subs.`status`=\"pending\", 1, null)) as process", false],
	    		["select", "COUNT(IF(mission_subs.`status`=\"success\", 1, null)) as success", false],
	    		["join", "mission_subs", "mission_subs.mission_id=missions.id and mission_subs.user_id={$user_id}", 'left'],
	    	]);

	    	if(!$sub) {
	    		$sub = new \stdClass();
		    	$sub->total = $sub->total ?? 0;
		    	$sub->process = $sub->process ?? 0;
		    	$sub->success = $sub->success ?? 0;
	    	}
	    	return $this->respond([
	    		"item" => $sub
	    	]);
	    } catch (\Throwable $th) {	    	
	    	return $this->respond([
	    		"message" => $th->getMessage(),
	    		"trace" => $th->getTrace()
	    	], 500);
	    }
	}

}