<?php

namespace App\Services\Whatsapp;

use App\Services\BaseServices;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use App\Services\Whatsapp\Config as WaConfig;
use App\Services\Whatsapp\Template as TemplateFactory;
use Exception;

class Whatsapp extends BaseServices {
	private $config;
	private $batchList = [];
	public $model;
	protected $base_url = "http://localhost:5000/api/default";

	public function __construct() {
		parent::__construct();
		$this->config = new WaConfig;
		$this->model = model("WhatsappsModel");
	}

	public function findOne($filter="") {
		if (is_array($filter)) {
			foreach ($filter as $value) {
				$params = $value;
				unset($params[ 0 ]);
				$this->model->{$value[ 0 ]}(...$params);
			}
		} else if (is_numeric($filter)) {
			$this->model->where('whatsapps.id', $filter);
		}
		return $this->model->first();
	}

	public function findAll($filter="") {
		$limit = [];
		if (is_array($filter)) {
			foreach ($filter as $value) {
				$params = $value;
				unset($params[ 0 ]);
				if($value[ 0 ] == 'limit') {
					$limit = $params;
					continue;
				}
				$this->model->{$value[ 0 ]}(...$params);
			}
		}
		return $this->model->findAll(...$limit);
	}

	public function create($data) {
		$this->model->insert($data);
		return $this->model->insertID();
	}

	public function update($filter, $data) {
		if(is_array($filter)){
			foreach ($filter as $value) {
				$params = $value;
				unset($params[ 0 ]);
				$this->model->{$value[ 0 ]}(...$params);
			}
			$this->model->set($data)->update();
		} else {
			$this->model->update($filter, $data);
		}
	}

	public function delete($id) {
		$this->model->delete($id);
	}

	public function send($phone, $message="") {
		try {
			if ($phone) {
				if (getenv('CI_ENVIRONMENT') != 'production') {
					$phone = $this->config->DEBUGGING_PHONE;
				}

				$url = "{$this->base_url}/send_message";

				$postData = http_build_query([
					"phone"   => $phone,
					"message" => $message
				]);

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
				curl_setopt($ch, CURLOPT_HTTPHEADER, [
					"Content-Type: application/x-www-form-urlencoded"
				]);

				$response = curl_exec($ch);

				if (curl_errno($ch)) {
					throw new Exception(curl_error($ch));
				}

				curl_close($ch);
				return $response;
			}
			return false;
		} catch (Exception $e) {
			return false;
		}
	}


	public function send_message($type, $to, $data) {
		$template = new TemplateFactory;
		if (method_exists($template, $type)){
			$message = $template->{$type}($data);
			$this->create(["phone" => $to, "message" => $message]);
			$this->send($to, $message);
		}
	}

	public function addBatchMessage($type, $phone, $data) {
		$template = new TemplateFactory;
		if (method_exists($template, $type)){
			$message = $template->{$type}($data);
			if (getenv('CI_ENVIRONMENT') != 'production'){
				$phone = $this->config->DEBUGGING_PHONE;
			}
			$this->create(["phone" => $phone, "message" => $message]);
			$this->batchList[] = (object) ["phone"=>$phone, "message"=>$message];
		}

		return $this;
	}

	public function getBatchMessage(){
		return $this->batchList;
	}

	public function sendBatchMessage() {
	    if (!$this->batchList) {
	        return false;
	    }

	    try {
	        $url = "{$this->base_url}/send_batch";

	        $payload = json_encode(["data" => $this->batchList]);

	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, [
	            "Content-Type: application/json",
	            "Content-Length: " . strlen($payload)
	        ]);

	        $response = curl_exec($ch);

	        if (curl_errno($ch)) {
	            throw new Exception(curl_error($ch));
	        }

	        curl_close($ch);

	        // reset setelah berhasil
	        $this->batchList = [];

	        return $response;
	    } catch (Exception $e) {
	        return false;
	    }
	}


	public function validatePhone($phone) {
		$phone = preg_replace("/[^0-9]/", "", $phone);
		$front = substr($phone, 0, 2);
		if($front=='62') {
			if(strlen($phone) > ($this->config->MIN_LENGTH + 1) && strlen($phone) < ($this->config->MAX_LENGTH + 1)) {
				return $phone;
			} else {
				return false;
			}
		} else if ($front=='08') {
			$phone = '62'.substr($phone, 1);
			if(strlen($phone) > $this->config->MIN_LENGTH && strlen($phone) < $this->config->MAX_LENGTH) {
				return $phone;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}