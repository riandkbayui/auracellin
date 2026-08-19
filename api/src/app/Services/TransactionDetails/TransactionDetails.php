<?php

namespace App\Services\TransactionDetails;

use App\Services\BaseServices;
use Exception;

class TransactionDetails extends BaseServices {

	public $model;

	public function __construct() {
		parent::__construct();
		$this->model = model("TransactionDetailsModel");
	}

	public function findOne($filter="") {
		if (is_array($filter)) {
			foreach ($filter as $value) {
				$params = $value;
				unset($params[ 0 ]);
				$this->model->{$value[ 0 ]}(...$params);
			}
		} else if (is_numeric($filter)) {
			$this->model->where('transaction_details.id', $filter);
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

	public function paginate($length, array $filter=[]) {
		foreach ($filter as $value) {
			$params = $value;
			unset($params[ 0 ]);
			$this->model->{$value[ 0 ]}(...$params);
		}
		$obj = new \stdClass();
		$obj->results = $this->model->paginate($length);
		$obj->pager = $this->model->pager;
		return $obj;
	}

	public function create($data) {
		$data = (object) $data;

		if(vars($data, "created_by")==="") {
			$data->created_by = user("id");
		}

		$this->model->insert($data);
		return $this->db->insertID();
	}

	public function update($filter, $data) {
		$data = (object) $data;

		if(vars($data, "updated_by")==="") {
			$data->updated_by = user("id");
		}

		if(is_array($filter)){
			foreach ($filter as $value) {
				$params = $value;
				unset($params[ 0 ]);
				$this->model->{$value[ 0 ]}(...$params);
			}
			$this->model->set($data)->update();
		} else if(is_numeric($filter)) {
			$this->model->update($filter, $data);
		} else {
			throw new Exception(lang("App.notfound", ["Update Primary Id"]));
		}
	}

	public function save($data){
	    $data = (object) $data;
	    try {
	    	if($data->id) {
	    		$this->update(intval($data->id), $data);
	    	} else {
	    		throw new Exception("No primary id");
	    	}
	    } catch (\Throwable $th) {
	    	$this->create($data);
	    }
	}

	public function delete($filter) {
		if(is_array($filter)){
			$this->db->transStart();
			$this->update($filter, ["deleted_by" => user("id")]);
			foreach ($filter as $value) {
				$params = $value;
				unset($params[ 0 ]);
				$this->model->{$value[ 0 ]}(...$params);
			}
			$this->model->delete();
			$this->db->transComplete();
		} else if (is_numeric($filter)) {
			$this->db->transStart();
			$this->model->where("id", $filter)->set(["deleted_by" => user("id")])->update();
			$this->model->where("id", $filter)->delete();
			$this->db->transComplete();
		} else {
			throw new Exception(lang("App.notfound", ["Update Primary Id"]));
		}
	}

	# customize functions is here :)

	

}
