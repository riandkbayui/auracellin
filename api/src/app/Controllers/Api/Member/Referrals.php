<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Referrals extends BaseController {

    private $upload_path = "uploads/profiles/";

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex(){
        try {
    		$tbl = "users";
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$user_id = userId();
			$params[] = ["where", "{$tbl}.sponsor_user_id", $user_id];

			$getTotal = service("Users")->findOne(array_merge($params, [
				["selectCount", "{$tbl}.id", "total"]
			]));


			$params[] = ["orderBy", "{$tbl}.id", "desc"];
			$params[] = ["select", ["{$tbl}.name", "{$tbl}.username", "{$tbl}.phone"]];
			$params[] = ["limit", $limit, $offset];
			$results = service("Users")->findAll($params);

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

    public function postRegister() {
        $rules = [
            "username"              => ["label" => "username", "rules" => "required|is_unique[users.username]", "errors" => ["is_unique" => lang("Validation.hasbeentaken", ['username'])]],
            "email"                 => ["label"=> "email", "rules"=>"required"],
            "name"                  => ["label"=> "nama", "rules"=>"required"],
            "phone"                 => ["label"=> "nomor telepon", "rules"=>"required"],
            "address"               => ["label"=> "alamat", "rules"=>"required"],
            "password"              => ["label" => "kata sandi", "rules"=>"required|min_length[8]"],
            "password_confrimation" => ["label" => "konfirmasi kata sandi", "rules"=>"required_with[password]|matches[password]"],
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

            if ($this->validate($rules)) {
                $password = $this->request->getPost('password');

                $obj = new \stdClass();
                $obj->username = $this->request->getPost("username");
                $obj->email = $this->request->getPost("email");
                $obj->name = $this->request->getPost("name");
                $obj->phone = $this->request->getPost("phone");
                $obj->phone = numeric($obj->phone);
                $obj->address = $this->request->getPost("address");
                $obj->password = $password;
                $obj->password = password_hash($obj->password, PASSWORD_DEFAULT);
                $obj->sponsor_user_id = user("id");
                $obj->package_id = "1";
                $obj->photo = "uploads/profiles/user.png";
                $obj->group = "member";
                $obj->status = "pending";

                $db = db_connect();
                $db->transStart();

                service("Users")->create($obj);

                service("Whatsapp")->send_message("welcome", $obj->phone, [
                    "name" => $obj->name,
                    "username" => $obj->username,
                    "password" => $password,
                ]);
                
                $db->transComplete();
                return $this->response->setJSON([
                    "message" => "Anggota ditambahkan!"
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