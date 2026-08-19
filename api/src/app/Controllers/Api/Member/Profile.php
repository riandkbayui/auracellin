<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;

use App\Services\Authentication\Config as AuthConfig;
use Exception;

class Profile  extends BaseController {
    private $authConfig;
    protected $pw_min_length = "0";

	private $upload_path = "uploads/profiles/";

    public function __construct() {
        parent::__construct();
        $this->authConfig = new AuthConfig();
        $this->pw_min_length = $this->authConfig->MIN_PASSWORD_LENGTH;
    }

    public function getIndex(){
        $session = service("Users")->session(userId());
        return $this->respond($session);
    }

    public function postIndex() {
    	$user_id = userId();

    	$rules = [
            "username" => ["label" => "username", "rules" => "required|is_unique[users.username,users.id,{$user_id}]", "errors" => ["is_unique" => lang("Validation.hasbeentaken", ['username'])]],
            "email"    => ["label"=> "email", "rules"=>"required"],
            "name"     => ["label"=> "nama", "rules"=>"required"],
            "phone"    => ["label"=> "nomor telepon", "rules"=>"required"],
    	];
    	
    	 try {
            $photo = $this->request->getFile("photo");
            $password = $this->request->getPost('password');
            $password_confrimation = $this->request->getPost('password_confrimation');

            if($password || $password_confrimation) {
                $rules = array_merge($rules, [
                    "password"              => ["label" => "kata sandi", "rules"=>"required|min_length[{$this->pw_min_length}]"],
                    "password_confrimation" => ["label" => "konfirmasi kata sandi", "rules"=>"required_with[password]|matches[password]"],
                ]);
            }

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $rules = array_merge($rules, [
                    "photo" => [ 'label' => 'Image File', 'rules' => 'uploaded[photo]'
                        . '|is_image[photo]'
                        . '|mime_in[photo,image/jpg,image/jpeg,image/png]'
                    ],
                ]);
            }

            if ($this->validate($rules)) {

                $data = [
                    "name"                 => $this->request->getPost('name'),
                    "username"             => $this->request->getPost('username', FILTER_CALLBACK, ["options"=>"inputUsername"]),
                    "email"                => $this->request->getPost('email', FILTER_CALLBACK, ["options"=>"inputEmail"]),
                    "phone"                => $this->request->getPost('phone', FILTER_SANITIZE_NUMBER_INT),
                ];

                if($password) {
                    $data["password"] = $this->request->getPost('password', FILTER_CALLBACK, ["options"=>"inputPassword"]);
                }

                if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                    $file_name = upload_img($photo, $this->upload_path, [
                        ['fit', 480, 480, 'center'],
                    ]);
                    if($file_name) $data['photo'] = $this->upload_path . $file_name;
                }

                service("Users")->update($user_id, $data);

                return $this->response->setJSON([
                    "message" => lang("App.updated", ["Profil Saya"])
                ]);
            } else {
                return $this->response->setStatusCode(400)->setJSON([
                    "message" => lang("Validation.invalid"),
                    "errors" => $this->validator->getErrors()
                ]);
            }
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                "message" => $e->getMessage(),
                "trace" => $e->getTrace()
            ]);
        }
    }

    public function postBank(){
        $rules = [
            "bank_id" => ["label"=> "bank", "rules"=>"required"],
            "bank_account_name" => ["label"=> "atas nama", "rules"=>"required"],
            "bank_account_address" => ["label"=> "nomor rekening", "rules"=>"required"],
        ];
        
        try {
            if ($this->validate($rules)) {
                $user = user();
                $user->bank_id = $this->request->getPost('bank_id', FILTER_SANITIZE_NUMBER_INT);
                $user->bank_account_name = $this->request->getPost('bank_account_name');
                $user->bank_account_address = $this->request->getPost('bank_account_address');
                service("Users")->save($user);
                return $this->response->setJSON([
                    "message" => "Berhasil memperbarui informasi!"
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