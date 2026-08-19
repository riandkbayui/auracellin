<?php

namespace App\Services\Mail;

use Exception;

class TemplateFactory
{

	public function __construct() {
		$this->office = service('configs')->getConfigByGroup("office");
	}

    public function welcome($data){
    	$office_name = $this->office->office_name ?? "";
		$result['subject'] = "Selamat anda terdaftar Di support system {$office_name}";
    	$data = array_merge((array) $this->office, $data);
		$result['message'] = view('email/welcome', $data);
		return $result;
	}

	public function forgot($data){
    	$office_name = $this->office->office_name ?? "";
		$result['subject'] = "Lupa kata sandi {$office_name}";
    	$data = array_merge((array) $this->office, $data);
		$result['message'] = view('email/forgot', $data);
		return $result;
	}

	public function notifications($data){
    	$office_name = $this->office->office_name ?? "";
		$result['subject'] = "{$subject} | {$office_name}";
    	$data = array_merge((array) $this->office, $data);
		$result['message'] = view('email/notifications', $data);
		return $result;
	}

}