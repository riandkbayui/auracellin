<?php

namespace App\Controllers\Cli;
use Exception;
use CodeIgniter\CLI\CLI;
use App\Controllers\Cli\BaseController;

class Generate extends BaseController {

    public function __construct() {
        helper('filesystem');
    }

    public function batch($list) {
        $list = preg_replace("/\s+/", " ", strtolower($list));
        $items = explode(",", $list);
        foreach ($items as $table_name) {
            $this->resource($table_name);
        }
    }

    public function resource($table_name) {
        $this->model($table_name);
        $this->service($table_name);
    }

    public function all(){
        $this->models();
        $this->services();
    }

    public function models() {
        $db = db_connect();
        $tables = $db->listTables();
        foreach ($tables as $table) {
            if(!in_array($table, ['_placeholder'])) {
                $this->model($table);
            }
        }
    }

    public function services() {
        $db = db_connect();
        $tables = $db->listTables();
        foreach ($tables as $table) {
            if(!in_array($table, ['_placeholder', 'attempts', 'configs', 'tokens', 'users'])) {
                $this->service($table);
            }
        }
    }

    public function model($table_name) {
        $db = db_connect();
        try {
            $fieldData = $db->getFieldData($table_name);
            $fields = array_column($fieldData, 'name');
            if($fields) {
                $useSoftDelete = 'true';
                $useTimestamp = 'false';

                $className = preg_replace("/[^0-9a-zA-Z]/", " ", $table_name);
                $className = preg_replace("/[\s+]/", " ", $className);
                $className = ucwords($className).'Model';
                $className = preg_replace("/[^0-9a-zA-Z]/", "", $className);

                foreach ($fields as $key => $value) {
                    if($value == 'id') {
                        unset($fields[$key]);
                    }

                    if($value == 'created_at') {
                        $useTimestamp = 'true';
                        unset($fields[$key]);
                    }

                    if($value == 'deleted_at') {
                        $useSoftDelete = 'true';
                        unset($fields[$key]);
                    }

                    if($value == 'updated_at') {
                        unset($fields[$key]);
                    }
                }

                $fields = (array) array_values($fields);

                $read = file_get_contents(WRITEPATH . 'generator' . DIRECTORY_SEPARATOR . 'model.php');
                $read = preg_replace("/{classname}/", $className, $read);
                $read = preg_replace("/{table}/", $table_name, $read);
                $read = preg_replace("/{useSoftDelete}/", $useSoftDelete, $read);
                $read = preg_replace("/{useTimestamp}/", $useTimestamp, $read);
                $read = preg_replace("/{fields}/", json_encode($fields), $read);
                $writepath = FCPATH . 'src' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "{$className}.php";
                write_file($writepath, $read);
                CLI::write("{$className}.php has been created.");
            } else {
                CLI::write('Table name not found.');
            }
        } catch (Exception $e) {
             CLI::write($e->getMessage());
        }
    }

    public function service($table_name) {
        $db = db_connect();
        try {
            $className = preg_replace("/[^0-9a-zA-Z]/", " ", $table_name);
            $className = preg_replace("/[\s+]/", " ", $className);
            $className = ucwords($className);
            $className = preg_replace("/[^0-9a-zA-Z]/", "", $className);

            $read = file_get_contents(WRITEPATH . 'generator' . DIRECTORY_SEPARATOR . 'service.php');
            $read = preg_replace("/{classname}/", $className, $read);
            $read = preg_replace("/{modelName}/", $className.'Model', $read);
            $read = preg_replace("/{table_name}/", $table_name, $read);
            $path =  FCPATH . 'src' . DIRECTORY_SEPARATOR . 'app' . 
                    DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR .
                    $className . DIRECTORY_SEPARATOR;
            if(!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            write_file(
               $path.
                "{$className}.php", $read
            );

            CLI::write("{$className}.php has been created.");
        } catch (Exception $e) {
             CLI::write($e->getMessage());
        }
    }

}