<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Studyrooms  extends BaseController {

	private $upload_path = "uploads/studyrooms/";

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

			$getTotal = service("StudyRooms")->findOne(array_merge($params, [
				["selectCount", "id", "total"]
			]));

			$params[] = ["orderBy", "study_rooms.id", "desc"];
			$params[] = ["select", ["study_rooms.code","study_rooms.photo", "study_rooms.name", "study_rooms.description", "study_rooms.package_id", "study_rooms.created_at"]];
			$params[] = ["select", ["IF(study_room_favs.id>0, true, false) as is_fav"], false];
			$params[] = ["select", ["packages.name as package_name"]];
			$params[] = ["join", "study_room_favs", "study_room_favs.study_room_id=study_rooms.id and study_room_favs.user_id={$user_id} and study_room_favs.status=\"active\"", "left"];
			$params[] = ["join", "packages", "packages.id=study_rooms.package_id"];
			$params[] = ["limit", $limit, $offset];
			$results = service("StudyRooms")->findAll($params);

			if(!$results) {
				throw new Exception("Data Kosong!");
			}

			$hasNext = ($offset + count($results)) < $getTotal->total;

			$results = array_map(function($obj){
				$obj->photo = base_url($obj->photo);
				return $obj;
			}, $results);

			return $this->respond([
				"limit" => $limit,
				"page" => $page,
				"results" => $results,
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

	public function getFavorites(){
		try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$user_id = userId();

			$params = [];
			$params[] = ["join", "study_room_favs", "study_room_favs.study_room_id=study_rooms.id and study_room_favs.user_id={$user_id} and study_room_favs.status=\"active\""];

			$getTotal = service("StudyRooms")->findOne(array_merge($params, [
				["selectCount", "study_rooms.id", "total"]
			]));

			$params[] = ["orderBy", "study_room_favs.updated_at", "desc"];
			$params[] = ["select", ["study_rooms.code","study_rooms.photo", "study_rooms.name", "study_rooms.description", "study_rooms.package_id", "study_rooms.created_at"]];
			$params[] = ["select", ["packages.name as package_name"]];
			$params[] = ["select", ["IF(study_room_favs.id>0, true, false) as is_fav"], false];
			$params[] = ["join", "packages", "packages.id=study_rooms.package_id"];
			$params[] = ["limit", $limit, $offset];
			$results = service("StudyRooms")->findAll($params);

			if(!$results) {
				throw new Exception("Data Kosong!");
			}

			$hasNext = ($offset + count($results)) < $getTotal->total;

			$results = array_map(function($obj){
				$obj->photo = base_url($obj->photo);
				return $obj;
			}, $results);

			return $this->respond([
				"limit" => $limit,
				"page" => $page,
				"results" => $results,
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
			$tbl = "study_rooms";
			$studyroom = service("StudyRooms")->findOne([
				["select", ["{$tbl}.id", "{$tbl}.user_id", "{$tbl}.code", "{$tbl}.name", "{$tbl}.photo", "{$tbl}.description", "{$tbl}.package_id", "{$tbl}.created_at"]],
				["select", "packages.name as package_name"],
				["join", "packages", "packages.id={$tbl}.package_id"],
				["where", "{$tbl}.code", $slug]
			]);

			if(!$studyroom) {
				throw new Exception(lang("App.notfound", ["Ruang Belajar"]));
			}

			$user = service("Users")->findOne([
				["select", ["photo", "name", "username"]],
				["where", "id", $studyroom->user_id]
			]);

			$tbl = "study_room_subs";
			$subs = service("StudyRoomSubs")->findAll([
				["select", ["{$tbl}.code", "{$tbl}.name", "{$tbl}.package_id"]],
				["select", ["packages.name as package_name"]],
				["join", "packages", "packages.id={$tbl}.package_id"],
				["where", "study_room_id", $studyroom->id]
			]);

			$studyroom->photo = base_url($studyroom->photo);
			$user->photo = base_url($user->photo);

			unset_var($studyroom, "id", "user_id");

			return $this->respond([
				"data" => $studyroom,
				"user" => $user,
				"subs" => $subs
			]);
		} catch (\Throwable $th) {
			return $this->respond([
				"message" => $th->getMessage()
			], 500);
		}
	}

	public function getSubs($slug){
		try {
			$slug = alphanumeric($slug);
			$tbl = "study_room_subs";
			$sub = service("StudyRoomSubs")->findOne([
				["select", ["{$tbl}.id", "{$tbl}.study_room_id","url", "{$tbl}.name", "{$tbl}.package_id", "{$tbl}.description"]],
				["select", ["packages.name as package_name"]],
				["join", "packages", "packages.id={$tbl}.package_id"],
				["where", "{$tbl}.code", $slug]
			]);

			if(!$sub) {
				throw new Exception(lang("App.notfound", ["Ruang Belajar"]));
			}

			$sub->url = youtube_embed($sub->url);

			$tbl = "study_rooms";
			$studyroom = service("StudyRooms")->findOne([
				["select", ["{$tbl}.id", "{$tbl}.user_id", "{$tbl}.code", "{$tbl}.name", "{$tbl}.photo", "{$tbl}.description", "{$tbl}.package_id", "{$tbl}.created_at"]],
				["select", ["packages.name as package_name"]],
				["join", "packages", "packages.id={$tbl}.package_id"],
				["where", "{$tbl}.id", $sub->study_room_id]
			]);

			$user = service("Users")->findOne([
				["select", ["photo", "name", "username"]],
				["where", "id", $studyroom->user_id]
			]);

			$tbl = "study_room_subs";
			$subs = service("StudyRoomSubs")->findAll([
				["select", ["{$tbl}.code", "{$tbl}.name", "{$tbl}.package_id"]],
				["select", ["packages.name as package_name"]],
				["join", "packages", "packages.id={$tbl}.package_id"],
				["where", "study_room_id", $studyroom->id],
				["where", "{$tbl}.id !=", $sub->id]
			]);

			unset_var($sub, "id", "study_room_id");

			$studyroom->photo = base_url($studyroom->photo);
			$user->photo = base_url($user->photo);

			return $this->respond([
				"data" => $sub,
				"user" => $user,
				"subs" => $subs,
			]);
		} catch (\Throwable $th) {
			return $this->respond([
				"message" => $th->getMessage()
			], 500);
		}
	}

	public function getMe(){
		try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];
			$params[] = ["where", "user_id", userId()];

			$getTotal = service("StudyRooms")->findOne(array_merge($params, [
				["selectCount", "id", "total"]
			]));

			$params[] = ["orderBy", "id", "desc"];
			$params[] = ["select", ["code","photo", "name", "description", "created_at"]];
			$params[] = ["limit", $limit, $offset];
			$results = service("StudyRooms")->findAll($params);

			if(!$results) {
				throw new Exception("Data Kosong!");
			}

			$hasNext = ($offset + count($results)) < $getTotal->total;

			$results = array_map(function($obj){
				$obj->photo = base_url($obj->photo);
				return $obj;
			}, $results);

			return $this->respond([
				"limit" => $limit,
				"page" => $page,
				"results" => $results,
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

	public function postCreate() {
		$rules = [
			"photo" => [ 'label' => 'Image File', 'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'],
			"name" => ["label"=> "judul", "rules"=>"required"],
			"package_id" => ["label"=> "paket", "rules"=>"required"],
			"description" => ["label"=> "deskripsi", "rules"=>"required"],
		];
		
		try {
			if ($this->validate($rules)) {
				$db = db_connect();
				$db->transStart();
				
				$data = new \stdClass();
				$data->name = $this->request->getPost('name');
				$data->description = $this->request->getPost('description');
				$data->package_id = $this->request->getPost('package_id');
				$data->user_id = userId();
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

				$study_room_id = service("StudyRooms")->create($data);

				$chapters = $this->request->getPost('chapter');
				if(!$chapters) {
					throw new Exception("Pastikan setidaknya ada satu chapter.");
				}
				foreach ($chapters as $key => $value) {
					$chapter = json_decode(json_encode($value));
					$chapter->study_room_id = $study_room_id;
					$chapter->created_by = userId();
					$chapter->code = str_rand();

					if(!isset_vars($chapter, "name", "url", "description", "package_id")) {
						throw new Exception("Pastikan form diisi dengan benar!");
					}

					$url = youtube_embed($chapter->url);
					if($url=='') {
						throw new Exception("Format url salah.");
					}

					service("StudyRoomSubs")->create($chapter);
				}
				$db->transComplete();
				return $this->response->setJSON([
					"message" => "Berhasil menambahkan ruang belajar!",
					"redirect_to" => "/member/studyrooms/me"
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
			$studyroom = service("StudyRooms")->findOne([
				["select", ["id", "code", "user_id", "photo", "name", "description", "package_id", "created_at"]],
				["where", "code", $slug],
				["where", "user_id", userId()]
			]);

			if(!$studyroom) {
				throw new Exception(lang("App.notfound", ["Study Room"]));
			}

			$subs = service("StudyRoomSubs")->findAll([
				["select", ["id", "code", "url", "name", "description", "package_id"]],
				["where", "study_room_id", $studyroom->id],
				["orderBy", "id", "asc"]
			]);

			$studyroom->photo = base_url($studyroom->photo);

			return $this->respond([
				"message" => lang("App.found", ["data"]),
				"form" => $studyroom,
				"subs" => $subs
			]);
		} catch (\Throwable $th) {
			return $this->respond([
				"message" => $th->getMessage(),
				"trace" => $th->getTrace()
			], 500);
		}
	}

	public function postEdit($slug){
		$rules = [
			"name" => ["label"=> "judul", "rules"=>"required"],
			"package_id" => ["label"=> "paket", "rules"=>"required"],
			"description" => ["label"=> "deskripsi", "rules"=>"required"],
		];
		
		try {
			$photo = $this->request->getFile('photo');
			
			if ($photo && $photo->isValid() && !$photo->hasMoved()) {
				$rules["photo"] = ['label' => 'Image File', 'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'];
			}

			if ($this->validate($rules)) {
				$slug = alphanumeric($slug);
				$data = service("StudyRooms")->findOne([
					["select", ["id", "code", "user_id", "photo", "name", "description", "package_id", "created_at"]],
					["where", "code", $slug],
					["where", "user_id", userId()]
				]);

				if(!$data) {
					throw new Exception(lang("App.notfound", ["Study Room"]));
				}

				$db = db_connect();
				$db->transStart();
				
				$data->name = $this->request->getPost('name');
				$data->package_id = $this->request->getPost('package_id');
				$data->description = $this->request->getPost('description');
				$data->updated_by = userId();

				if ($photo && $photo->isValid() && !$photo->hasMoved()) {
					$file_name = upload_img($photo, $this->upload_path, [
						['fit', 960, 540, 'center'],
					]);

					if ($file_name) {
						$data->photo = $this->upload_path . $file_name;
					}
				}

				service("StudyRooms")->save($data);

				$chapters = $this->request->getPost('chapter');
				if(!$chapters) {
					throw new Exception("Pastikan setidaknya ada satu chapter.");
				}
				foreach ($chapters as $key => $value) {

					$chapter = json_decode(json_encode($value));

					if(!isset_vars($chapter, "name", "url", "description", "package_id")) {
						throw new Exception("Pastikan form diisi dengan benar!");
					}

					$url = youtube_embed($chapter->url);
					if($url=='') {
						throw new Exception("Format url salah.");
					}

					$chp = service("StudyRoomSubs")->findOne([
						["where", "id", ($chapter->id ?? "-")],
						["where", "study_room_id", $data->id]
					]);
					
					if($chp) {
						$chapter->updated_by = userId();
						service("StudyRoomSubs")->update($chp->id, $chapter);
					} else {
						$chapter->created_by = userId();
						$chapter->code = str_rand();
						$chapter->study_room_id = $data->id;
						service("StudyRoomSubs")->create($chapter);
					}

				}
				$db->transComplete();
				return $this->response->setJSON([
					"message" => "Ruang belajar diperbarui!",
					"redirect_to" => "/member/studyrooms/me"
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

	public function postSubs_delete(){
		try {
			$id = $this->request->getPost('id', FILTER_SANITIZE_NUMBER_INT);
			$study_room_id = $this->request->getPost('study_room_id', FILTER_SANITIZE_NUMBER_INT);
			$study_room = service("StudyRooms")->findOne([
				["where", "id", $study_room_id],
				["where", "user_id", userId()]
			]);

			if(!$study_room) {
				throw new Exception(lang("App.notfound", ["Ruang Belajar"]));
			}

			service("StudyRoomSubs")->delete([
				["where", "id", $id],
				["where", "study_room_id", $study_room->id]
			]);

			return $this->respond([
				"message" => lang("App.deleted", ["Ruang Belajar"])
			]);
		} catch (\Throwable $th) {
			return $this->respond([
				"message" => $th->getMessage(),
				"trace" => $th->getTrace()
			], 500);
		}
	}

	public function postFav(){
	    try {
	    	$code = $this->request->getPost('code');
	    	$code = alphanumeric($code);
	    	$studyroom = service("StudyRooms")->findOne([
	    		["where", "code", $code]
	    	]);

	    	if(!$studyroom) {
	    		throw new Exception(lang("App.notfound", ["Ruang Belajar"]));
	    	}

	    	$fav = service("StudyRoomFavs")->findOne([
	    		["where", "study_room_id", $studyroom->id],
	    		["where", "user_id", userId()]
	    	]);

	    	$message = "Favorit ditambahkan!";

	    	if($fav) {
	    		if($fav->status=="active") {
	    			$fav->status = "inactive";
	    			$message = "Favorit dihapus!";
	    		} else {
	    			$fav->status = "active";
	    		}
	    		$fav->updated_by = userId();
	    		 service("StudyRoomFavs")->save($fav);
	    	} else {
	    		$fav = new \stdClass();
	    		$fav->status = "active";
	    		service("StudyRoomFavs")->create([
	    			"study_room_id" => $studyroom->id,
	    			"user_id" => userId(),
	    			"status" => "active"
	    		]);
	    	}

	    	return $this->respond([
				"message" => $message,
				"fav_status" => $fav->status
			]);
	    } catch (\Throwable $th) {
	    	return $this->respond([
				"message" => $th->getMessage(),
				"trace" => $th->getTrace()
			], 500);
	    }
	}

	public function postDelete(){
	    $rules = [
	        "code" => ["label"=> "kode", "rules"=>"required"],
	    ];
	    
	    try {
	        if ($this->validate($rules)) {
	    		$code = $this->request->getPost('code');
	    		$code = alphanumeric($code);
	    		service("StudyRooms")->delete([
	    			["where", "code", $code],
	    			["where", "user_id", user("id")]
	    		]);
	            return $this->response->setJSON([
	                "message" => "Ruang Belajar Dihapus!"
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