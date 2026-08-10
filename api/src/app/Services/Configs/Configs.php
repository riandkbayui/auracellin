<?php

namespace App\Services\Configs;

use App\Services\BaseServices;
use Exception;

class Configs extends BaseServices {

	public $model;
	public $office;

	public function __construct() {
		parent::__construct();
		$this->model = model("ConfigsModel");
	}

	public function findOne($filter="") {
		if (is_array($filter)) {
			foreach ($filter as $value) {
				$params = $value;
				unset($params[ 0 ]);
				$this->model->{$value[ 0 ]}(...$params);
			}
		} else if (is_numeric($filter)) {
			$this->model->where('configs.id', $filter);
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

	public function getConfigs($params=[]){
        $configs = $this->findAll($params);
        $data = new \stdClass();
        foreach ($configs as $config) {
            json_decode($config->value);
            if (json_last_error() === JSON_ERROR_NONE){
                $value = json_decode($config->value);
            } else {
                $value = $config->value;
            }
            $data->{$config->key} = $value;
        }
        return $data;
    }
    
    public function getConfig($key, $valueOnly = true){
        $config = getenv($key);
        $v = null;
        if (!empty($config)){
            return $config;
        }
        $config = $this->findOne([
            ["where", "key", $key]
        ]);
        $value = json_decode($config->value);
        if (json_last_error() === JSON_ERROR_NONE){
            $v = $value;
        } else {
            $v = $config->value;
        }
        if ($valueOnly){
            return $v;
        }
        $config->value = $v;
        return $config;
    }

    function getConfigByKey($key) {
        return $this->model->where('key', $key)->get()->getRow('value');
    }
    
    public function getConfigByGroup($group){
        $configs = $this->model->where('group', $group)->find();
        $data = new \stdClass();
        foreach ($configs as $config) {
            json_decode($config->value);
            if (json_last_error() === JSON_ERROR_NONE){
                $value = json_decode($config->value);
            } else {
                $value = $config->value;
            }
            $data->{$config->key} = $value;
        }
        return $data;
    }

    public function updateConfig($key, $value) {
        $userId = userId();
        $this->update([
            ["where", "key", $key]
        ], [
            "value" => $value,
            "updated_by" => $userId
        ]);
    }

    public function write_officedata(){
        $this->office = $this->getConfigByGroup("office");
        return $this;
    }

    public function officedata($key){
        if($key) {
            return $this->office->{$key};
        } else {
            return $this->office;
        }
    }

}
