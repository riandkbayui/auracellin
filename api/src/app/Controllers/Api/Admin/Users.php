<?php

namespace App\Controllers\Api\Admin;
use App\Controllers\BaseController;
use Exception;

class Users  extends BaseController {

	private $upload_path = "assets/uploads/profiles/";

	public function __construct() {
		parent::__construct();
		//do_nothing
	}

	public function getIndex(){
	    try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$search = $this->request->getGet('search');
			$search = alphanumeric($search);
			$offset = ($page - 1) * $limit;
			$params = [];

			if($search) {
				$params[] = ["groupStart"];
				$params[] = ["like", "name", $search];
				$params[] = ["orLike", "username", $search];
				$params[] = ["orlike", "phone", $search];
				$params[] = ["groupEnd"];
			}

			$getTotal = service("Users")->findOne(array_merge($params, [
				["selectCount", "users.id", "total"]
			]));

			$params[] = ["orderBy", "users.id", "desc"];
			$params[] = ["select", ["users.id", "users.name", "users.phone", "users.username", "users.photo", "users.status"]];
			$params[] = ["limit", $limit, $offset];
			$results = service("Users")->findAll($params);

			if(!$results) {
				throw new Exception("Data kosong!");
			}

			$hasNext = ($offset + count($results)) < $getTotal->total;

			$results = array_map(function($obj){
				$obj->photo = base_url($obj->photo);
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

	public function getEdit($id){
	    try {
	    	$id = numeric($id);
	    	$user = service("Users")->findOne([
	    		["select", ["package_id", "group","photo","name","username", "phone","email","address","status"]],
				["where", "id", $id]
			]);

			if(!$user) {
				throw new Exception("Pengguna tidak ditemukan!");
			}

			$user->photo = base_url($user->photo);

			return $this->respond(compact("user"));
	    } catch (\Throwable $th) {
	    	return $this->respond([
	    		"message" => $th->getMessage()
	    	], 500);
	    }
	}

	public function postEdit($id){
		$id = numeric($id);
		$rules = [
			"username" => ["label" => "username", "rules" => "required|is_unique[users.username,users.id,{$id}]", "errors" => ["is_unique" => lang("Validation.hasbeentaken", ['username'])]],
			"email"    => ["label"=> "email", "rules"=>"required"],
			"name"     => ["label"=> "nama", "rules"=>"required"],
			"phone"    => ["label"=> "nomor telepon", "rules"=>"required"],
			"package_id"  => ["label"=> "paket", "rules"=>"required"],
			"group"    => ["label"=> "grup", "rules"=>"required|in_list[member,admin]"],
			"status"   => ["label"=> "status", "rules"=>"required|in_list[active,inactive]"],
		];
		
		try {
			$photo = $this->request->getFile("photo");
			if ($photo && $photo->isValid() && !$photo->hasMoved()) {
				$rules = array_merge($rules, [
						"photo" => [ 'label' => 'Image File', 'rules' => 'uploaded[photo]'
						. '|is_image[photo]'
						. '|mime_in[photo,image/jpg,image/jpeg,image/png]'
					],
				]);
			}

			$password = $this->request->getPost('password');
            $password_confrimation = $this->request->getPost('password_confrimation');

            if($password || $password_confrimation) {
                $rules = array_merge($rules, [
                    "password"              => ["label" => "kata sandi", "rules"=>"required|min_length[{$this->pw_min_length}]"],
                    "password_confrimation" => ["label" => "konfirmasi kata sandi", "rules"=>"required_with[password]|matches[password]"],
                ]);
            }

			if ($this->validate($rules)) {
				$user = service("Users")->findOne([
					["where", "id", $id]
				]);

				if(!$user) {
					throw new Exception("Pengguna tidak ditemukan!");
				}

				$user->username = $this->request->getPost('username', FILTER_CALLBACK, ["options"=>"inputUsername"]);
				$user->email = $this->request->getPost('email', FILTER_CALLBACK, ["options"=>"inputEmail"]);
				$user->name = $this->request->getPost('name');
				$user->phone = $this->request->getPost('phone', FILTER_SANITIZE_NUMBER_INT);
				$user->package_id = $this->request->getPost('package_id');
				$user->address = $this->request->getPost('address');
				$user->group = $this->request->getPost('group');
				$user->status = $this->request->getPost('status');

				if ($photo && $photo->isValid() && !$photo->hasMoved()) {
					$file_name = upload_img($photo, $this->upload_path, [
						['fit', 480, 480, 'center'],
					]);
					if($file_name) $user->photo = $this->upload_path . $file_name;
				}

				if($password) {
                    $user->password = $this->request->getPost('password', FILTER_CALLBACK, ["options"=>"inputPassword"]);
                }

				service("Users")->save($user);

				return $this->response->setJSON([
					"message" => "Berhasil memperbarui data pengguna!",
					"redirect_to" => base_url("admin/users")
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

	public function postProfile(){
	    try {
	    	$id = $this->request->getPost('id', FILTER_SANITIZE_NUMBER_INT);
	    	
	    	$user = service('Users')->findOne([
	    		["where", "id", $id]
	    	]);

	    	if(!$user) {
	    		throw new Exception("Member tidak ditemukan!");
	    	}

	    	$user = unset_var($user, "password", "created_by", "updated_by", "deleted_by", "deleted_at");
	    	return $this->respond($user);
	    } catch (\Throwable $th) {
	    	return $this->respond([
	    		"message" => $th->getMessage()
	    	], 500);
	    }
	}

    public function postSelect2(){
        try {
            $search = $this->request->getPost("q");
            $results = service("Users")->findAll([
                ["asArray"],
                ["select", ["id", "username as text"]],
                ["like", "username", $search],
                ["orderBy", "username"],
                ["limit", "25"]
            ]);
            return $this->respond(compact("results"));
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage()
            ], 500);
        }
    }

}