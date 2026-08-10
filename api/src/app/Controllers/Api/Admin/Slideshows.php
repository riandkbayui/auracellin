<?php

namespace App\Controllers\Api\Admin;
use App\Controllers\BaseController;
use Exception;

class Slideshows  extends BaseController {

    private $upload_path = "uploads/slideshows/";

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex() {
        try {
            $limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
            $page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
            $offset = ($page - 1) * $limit;
            $params = [];

            $getTotal = service("Slideshows")->findOne(array_merge($params, [
                ["selectCount", "slideshows.id", "total"]
            ]));

            $params[] = ["orderBy", "slideshows.id", "desc"];
            $params[] = ["select", ["slideshows.id", "slideshows.photo", "slideshows.status"]];
            $params[] = ["limit", $limit, $offset];
            $results = service("Slideshows")->findAll($params);

            if(!$results) {
                throw new Exception("Data kosong!");
            }

            $hasNext = ($offset + count($results)) < $getTotal->total;

			$results = array_map(function($obj){
				$obj->photo = base_url($obj->photo);
				return $obj;
			}, $results);

            return $this->respond([
                "limit" => $limit,
                "page" => $page,
                "results" => nestArray($results),
                "total" => $getTotal->total,
                "has_next" => $hasNext
            ]);
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage(),
                "trace" => $th->getTrace()
            ], 500);
        }
    }

    public function postAdd(){
        $rules = [
            "status" => ["label" => "status", 'rules' => 'required'],
            "photo"  => [ 'label' => 'Image File', 'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'],
        ];
        
        try {
            if ($this->validate($rules)) {
                $photo = $this->request->getFile('photo');
                
                $obj = new \stdClass();
                $obj->status =  $this->request->getPost('status');

                if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                    $file_name = upload_img($photo, $this->upload_path, [
                        ['fit', 960, 540, 'center'],
                    ]);
                    $obj->photo = $this->upload_path . $file_name;
                } else {
                    throw new Exception("Format file tidak valid!");
                }

                service("Slideshows")->create($obj);

                return $this->response->setJSON([
                    "message" => "Slideshow ditambahkan."
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

    public function getEdit($id){
        try {
            $id = numeric($id);
            $form = service("Slideshows")->findOne([
                ["select", ["id", "photo", "status"]],
                ["where", "id", $id]
            ]);
            if(!$form) {
                throw new Exception("Slideshow tidak ditemukan!");
            }
            $form->photo = base_url($form->photo);
            return $this->respond(compact("form"));
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function postEdit($id){
        $rules = [
            "status" => ["label" => "status", 'rules' => 'required'],
        ];
        
        try {
            $photo = $this->request->getFile('photo');
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $rules["photo"] = [ 'label' => 'Image File', 'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'];
            }

            if ($this->validate($rules)) {
                $slideshow = service("Slideshows")->findOne([
                    ["where", "id", numeric($id)]
                ]);

                if(!$slideshow) {
                    throw new Exception("Slideshow tidak ditemukan!");
                }

        
                $obj = new \stdClass();
                $obj->status =  $this->request->getPost('status');

                if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                    $file_name = upload_img($photo, $this->upload_path, [
                        ['fit', 960, 540, 'center'],
                    ]);
                    if($file_name) {
                        $obj->photo = $this->upload_path . $file_name;
                    }
                }

                service("Slideshows")->update($slideshow->id, $obj);

                return $this->response->setJSON([
                    "message" => "Slideshow diperbarui."
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

    public function postDelete(){
        try {
            $id = $this->request->getPost('id');
            $slideshow = service("Slideshows")->findOne([
                ["where", "id", $id]
            ]);
            if(!$slideshow) {
                throw new Exception("Slideshow tidak ditemukan!");
            }
            service("Slideshows")->delete($slideshow->id);
            return $this->respond([
                "message" => "Slideshow dihapus"
            ]);
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage()
            ], 500);
        }
    }

}