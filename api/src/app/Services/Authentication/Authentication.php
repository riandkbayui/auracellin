<?php

namespace App\Services\Authentication;

use App\Services\Authentication\Config as AuthConfig;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use App\Services\BaseServices;

class Authentication extends BaseServices {

    protected $config;
    public $userdata;
    public $prevUserdata;
    public $payload;

    public function __construct()  {
        parent::__construct();
        $this->config = new AuthConfig;
    }

    public function passVerify($password){
        if(prevUserId()) {
            $verify = password_verify(strval($password), prevUser('password'));
            if(!$verify) throw new Exception(lang("App.notmatch", ["Kata sandi"]));
        } else {
            $verify = password_verify(strval($password), user('password'));
            if(!$verify) throw new Exception(lang("App.notmatch", ["Kata sandi"]));
        }
    }

    public function signIn($identity, $password, $remember=true) {
        $identity = strtolower($identity);
        $identity = nospace($identity);

        $filter = [];
        $filter[] = ['groupStart'];
        foreach ($this->config->VALID_IDENTITY as $key => $value) {
            if($key==0) {
                $filter[] = ["where", $value, $identity];
            } else {
                $filter[] = ["orWhere", $value, $identity];
            }
        }
        $filter[] = ['groupEnd'];
        $user = service('Users')->findOne($filter);
        if($user) {
            $verify = password_verify($password, $user->password);
            if (strtolower($user->status) == "pending") {
                throw new Exception("Akun anda masih dalam proses verifikasi. Anda bisa segera menghubungi admin jika akun anda belum kunjung diverifikasi.");
            }
            if($verify) {
                $result = $this->login($user->id, $remember);
                if ($result){
                    $response = new \stdClass();
                    $response->access_token = $result;
                    $response->token_type = 'Bearer';
                    $response->expires_in = 3600;
                    $response->scope = 'resource.READ, resource.WRITE';
                    $response->user = new \stdClass();
                    $response->user->id = $user->id;
                    $this->attemptAuth($user->id, "SIGNIN", $isSuccess = true, $reason = '');
                    return $response;
                }
                return false;
            } else {
                $this->attemptAuth($user->id, 'SIGNIN', false, 'password invalid');
                throw new Exception(lang('Auth.invalidPassword'));
            }
        } else {
            throw new Exception(lang('Auth.userNotFound', [$identity]));
        }
        return false;
    }

    public function register($data){
        $plain_password = $data->password;
        $data->group = "member";
        $data->password = password_hash($data->password, PASSWORD_DEFAULT);
        $data->photo = "assets/uploads/profiles/user.png";
        $data->status = "active";

        if($data->referral) {
            $referral = service("Users")->findOne([
                ["where", "username", $data->referral],
                ["where", "status", "active"]
            ]);

            if($referral) {
                $data->sponsor_user_id = $referral->id;
            } else {
                throw new Exception("Referral tidak ditemukan!");
            }
        }

        $id = service("Users")->create($data);
        $data->id = $id;
        $data->password = $plain_password;
        return $data;
    }

    public function user($key="") {
        if($this->userdata) {
            if($key) {
                return isset($this->userdata->{$key}) ? $this->userdata->{$key} : "";
            } else {
                $user = $this->userdata;
                return $user;
            }
        } else {
            return false;
        }
    }

    public function prevUser($key="") {
        if($this->prevUserdata) {
            if($key) {
                return isset($this->prevUserdata->{$key}) ? $this->prevUserdata->{$key} : "";
            } else {
                $user = $this->prevUserdata;
                return $user;
            }
        } else {
            return false;
        }
    }

    public function login($userId, $remember = false) {
        try {
            $payload = [
                'userId'   => $userId
            ];

            $jwt = JWT::encode($payload, $this->config->JWT_SECRET, $this->config->JWT_ALGO);
            $age = $remember ? time() + $this->config->COOKIE_AGE_REMEMBER : time() + $this->config->COOKIE_AGE_DEFAULT;
            setcookie(
                $this->config->COOKIE_NAME,
                $jwt,
                [
                    'expires' => $age,
                    'path' => '/',
                    'secure' => false,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]
            );
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }

        return $jwt;
    }

    public function forgot($username) {
        $user = service("Users")->findOne([
            ['where', 'username', $username],
        ]); 
        if ($user) {
            $token = random_string('crypto', 32);
            service("Tokens")->create([
                "user_id" => $user->id,
                "type" => "RESET_PASSWORD",
                "token" => $token,
                "expired_at" => date("Y-m-d H:i:s", strtotime("+1day"))
            ]);
            $this->attemptAuth($user->id, "FORGOT", $isSuccess = true, $reason = '');
            service("Whatsapp")->send_message("forgot", $user->phone, [
                "name" => $user->name,
                "username" => $user->username,
                "link" => landing_url("auth/recover/{$token}"),
            ]);
            return [$user, $token];
        } else {
            throw new Exception("Akun tidak ditemukan.");
        }
    }

    public function forgotUpdate($token, $password) {
        $validate = $this->forgotTokenValidate($token);
        if($validate) {
            $this->db->transStart();
            service("Users")->update($validate->user_id, [
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ]);
            service("Tokens")->delete($validate->id);
            $this->db->transComplete();
            return $validate;
        } else {
            throw new Exception("Token tidak valid, silahkan ulangi proses lupa kata sandi.");
            return false;
        }
    }

    public function forgotTokenValidate($token) {
        $validate = service("Tokens")->findOne([
            ['where', 'token', $token],
            ['where', 'type', "RESET_PASSWORD"],
            ['where', 'expired_at >', date("Y-m-d H:i:s")]
        ]);

        if ($validate) {
            $this->attemptAuth($validate->user_id, 'RESET_PASSWORD', true);
            return $validate;
        } else {
            return false;
        }
    }

    public function set_userdata($data) {
        $this->userdata = $data;
        return $data;
    }

    public function set_prevUserdata($data) {
        $this->prevUserdata = $data;
        return $data;
    }

    public function logout() {
        if (isset($_SESSION)) {
            foreach ($_SESSION as $key => $value) {
                $_SESSION[$key] = null;
                unset($_SESSION[$key]);
            }
        }
    
        $session = session();
        $session->destroy();

        if (isset($_COOKIE[$this->config->COOKIE_NAME])) {
            unset($_COOKIE[$this->config->COOKIE_NAME]);
            setcookie(
                $this->config->COOKIE_NAME,
                '',
                [
                    'expires' => -1,
                    'path' => '/',
                    'secure' => false,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]
            );
            return true;
        } else {
            return false;
        }
    }

    public function inGroup($group = 'member') {
        return $this->userdata->group === $group;
    }

    private function getAuthorizationHeader() {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    private function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    public function session($key="") {
        $jwt = $this->getBearerToken();
        if (empty($jwt)) {
            if (array_key_exists($this->config->COOKIE_NAME, $_COOKIE)) {
                $jwt = $_COOKIE[$this->config->COOKIE_NAME];
            }
        }
    
        if (empty($jwt)) {
            return false;
        }

        try {
            $payload = JWT::decode($jwt, new Key($this->config->JWT_SECRET, $this->config->JWT_ALGO));
            if($key) {
                return vars($payload, $key);
            } else {
                return $payload;
            }
        } catch (Exception $exception) {
            return false;
        }
    }

    public function login_as($id) {
        $remember = true;

        helper('date');
        try {
            $payload = [
                'userId'   => $id,
                'prevUserId' => userId(),
            ];

            $jwt = JWT::encode($payload, $this->config->JWT_SECRET, $this->config->JWT_ALGO);
            $age = $remember ? time() + $this->config->COOKIE_AGE_REMEMBER : time() + $this->config->COOKIE_AGE_DEFAULT;
            setcookie(
                $this->config->COOKIE_NAME,
                $jwt,
                [
                    'expires' => $age,
                    'path' => '/',
                    'secure' => false,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]
            );
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
        return $jwt;
    }

    public function attemptAuth($userId, $action, $isSuccess = true, $reason = '') {
        $AttemptModel = model('AttemptsModel');
        $AttemptModel->insert([
            'user_id' => $userId,
            'action' => $action,
            'is_success' => $isSuccess,
            'reason' => $reason,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
        return true;
    }
}
