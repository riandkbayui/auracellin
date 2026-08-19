<?php

namespace App\Services\Forms;

use App\Services\BaseServices;
use Exception;

class Forms extends BaseServices {

	public $model;

	public function __construct() {
		parent::__construct();
		$this->model = model("FormsModel");
	}

	public function findOne($filter="") {
		if (is_array($filter)) {
			foreach ($filter as $value) {
				$params = $value;
				unset($params[ 0 ]);
				$this->model->{$value[ 0 ]}(...$params);
			}
		} else if (is_numeric($filter)) {
			$this->model->where('forms.id', $filter);
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
			$data->created_by = userId();
		}

		$this->model->insert($data);
		return $this->db->insertID();
	}

	public function update($filter, $data) {
		$data = (object) $data;

		if(vars($data, "updated_by")==="") {
			$data->updated_by = userId();
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
	    return $this->model->save($data);
	}

	public function delete($filter) {
		if(is_array($filter)){
			$this->db->transStart();
			$this->update($filter, ["deleted_by" => userId()]);
			foreach ($filter as $value) {
				$params = $value;
				unset($params[ 0 ]);
				$this->model->{$value[ 0 ]}(...$params);
			}
			$this->model->delete();
			$this->db->transComplete();
		} else if (is_numeric($filter)) {
			$this->db->transStart();
			$this->model->where("id", $filter)->set(["deleted_by" => userId()])->update();
			$this->model->where("id", $filter)->delete();
			$this->db->transComplete();
		} else {
			throw new Exception(lang("App.notfound", ["Update Primary Id"]));
		}
	}

	# customize functions is here :)

	

}
