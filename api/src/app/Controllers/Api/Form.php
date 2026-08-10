<?php

namespace App\Controllers\Api;
use App\Controllers\BaseController;
use Exception;

class Form  extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex($slug){
        try {
            $slug = alphanumeric($slug);
            $form = service("Forms")->findOne([
                ["select", ["name", "slug", "text_start", "text_end", "fields", "phones", "status"]],
                ["where", "slug", $slug],
            ]);

            if(!$form) {
                throw new Exception("Form tidak ditemukan!");
            }

            $form->fields = json_decode($form->fields);
            $form->fields = array_map(function($v){
            	$obj = new \stdClass();
            	$obj->key = $v;
            	$obj->val = '';
            	return $obj;
            }, $form->fields);
            $form->phones = explode(";", $form->phones);
            $phone = $form->phones[array_rand($form->phones)];
            $form->phone = $phone;
            unset($form->phones);
            return $this->respond(compact("form"));
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage()
            ], 500);
        }
    }

}