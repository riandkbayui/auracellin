<?php

namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Services\Authentication\Config as AuthConfig;
use Exception;

class Auth extends BaseController {

    public function __construct() {
        parent::__construct();
		$this->authConfig = new AuthConfig();
		$this->pw_min_length = $this->authConfig->MIN_PASSWORD_LENGTH;
    }

    public function postLogin() {
        try {
			$rules = [
				"username" => ["label" => "username or email", "rules" => "required"],
				"password" => ["label" => "password", "rules" => "required|min_length[{$this->authConfig->MIN_PASSWORD_LENGTH}]"],
			];

			if ($this->validate($rules)) {

				$username = $this->request->getPost("username");
				$password = $this->request->getPost("password");
				$auth = service('Authentication')->signIn($username, $password);
				$login = [
					"message" => "Login berhasil.",
					"auth" => $auth
				];

				return $this->respond($login);
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

	public function postRegister(){
		$rules = [
			"name"             => ["label"=> "id", "rules"=>"required"],
			"phone"            => ["label"=> "id", "rules"=>"required"],
			"email"            => ["label"=> "id", "rules"=>"required"],
			"profesion"       => ["label"=> "id", "rules"=>"required"],
			"address"          => ["label"=> "id", "rules"=>"required"],
			"username"         => ["label"=> "username", "rules"=>"required|is_unique[users.username]"],
			"password"         => ["label" => "password", "rules" => "required|min_length[{$this->authConfig->MIN_PASSWORD_LENGTH}]"],
			"password_confirm" => ["label" => "konfirmasi kata sandi", "rules" => "required_with[password]|matches[password]"],
		];
		
		try {
			if ($this->validate($rules)) {
				$obj = new \stdClass();
				$obj->name = $this->request->getPost("name");
				$obj->phone = $this->request->getPost("phone");
				$obj->email = $this->request->getPost("email");
				$obj->profesion = $this->request->getPost("profesion");
				$obj->address = $this->request->getPost("address");
				$obj->username = $this->request->getPost("username");
				$obj->password = $this->request->getPost("password");
				$obj->referral = $this->request->getPost("referral");
				$user = service("Authentication")->register($obj);
				service("Authentication")->login($user->id);
				return $this->response->setJSON([
					"message" => "Membuat akun!",
					"redirect_to" => "/member/dashboard"
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

	public function getFaker(){
		try {
			$user = new \stdClass();
			$user->name = faker("name");
			$user->username = alphanumeric(faker("username"));
			$user->phone = numeric(faker("phoneId"));
			$user->email = faker("email");
			$user->address = faker("address");
			$user->profesion = faker("jobTitle");
			$user->password = "password";
			return $this->respond($user);
		} catch (\Throwable $th) {
			return $this->respond([
				"message" => $th->getMessage()
			], 500);
		}
	}

	public function postForgot(){
		$rules = [
			"username" => ["label"=> "username", "rules"=>"required"],
		];
		
		try {
			if ($this->validate($rules)) {
				$username = $this->request->getPost("username");
				$user = service("Authentication")->forgot($username);
				return $this->response->setJSON([
					"message" => "Mengirim permintaan reset sandi!",
					"redirect_to" => "/auth/login"
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

	public function postRecover($token){
		$rules = [
			"password"         => ["label" => "password", "rules" => "required|min_length[{$this->authConfig->MIN_PASSWORD_LENGTH}]"],
			"password_confrimation" => ["label" => "konfirmasi kata sandi", "rules" => "required_with[password]|matches[password]"],
		];
		
		try {
			if ($this->validate($rules)) {
				$password = $this->request->getPost("password");
				$token = alphanumeric($token);
				$validate = service("Authentication")->forgotUpdate($token, $password);
				service("Authentication")->login($validate->user_id);
				return $this->response->setJSON([
					"message" => "Mengatur ulang sandi!",
					"redirect_to" => "/member/dashboard"
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

    public function getLogout(){
        service('Authentication')->logout();
        return $this->respond([
        	"message" => "Logout!"
        ]);
    }

}