<?php

namespace App\Controllers\Api\Admin;
use App\Controllers\BaseController;
use Exception;

class Products extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    private $upload_path = "uploads/products/";

    public function getIndex() {
        try {
            $limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
            $page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
            $offset = ($page - 1) * $limit;
            $params = [];

            $getTotal = service("Products")->findOne(array_merge($params, [
                ["selectCount", "products.id", "total"]
            ]));

            $params[] = ["orderBy", "products.id", "desc"];
            $params[] = ["select", ["products.id", "products.name", "products.photo", "products.description", "products.price", "products.status"]];
            $params[] = ["limit", $limit, $offset];
            $results = service("Products")->findAll($params);

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
            "name" => ["label" => "nama", 'rules' => 'required'],
            "status" => ["label" => "status", 'rules' => 'required'],
            "price" => ["label" => "harga", 'rules' => 'required'],
            "description" => ["label" => "deskripsi", 'rules' => 'required'],
            "photo"  => [ 'label' => 'Image File', 'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'],
        ];
        
        try {
            if ($this->validate($rules)) {
                $photo = $this->request->getFile('photo');
                
                $obj = new \stdClass();
                $obj->name =  $this->request->getPost('name');
                $obj->price =  $this->request->getPost('price');
                $obj->status =  $this->request->getPost('status');
                $obj->description =  $this->request->getPost('description');

                if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                    $file_name = upload_img($photo, $this->upload_path, [
                        ['fit', 720, 720, 'center'],
                    ]);
                    $obj->photo = $this->upload_path . $file_name;
                } else {
                    throw new Exception("Format file tidak valid!");
                }

                service("Products")->create($obj);

                return $this->response->setJSON([
                    "message" => "Produk ditambahkan."
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
            $form = service("Products")->findOne([
                ["select", ["id", "name", "price", "photo", "description", "status"]],
                ["where", "id", $id]
            ]);
            if(!$form) {
                throw new Exception("Produk tidak ditemukan!");
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
            "name" => ["label" => "nama", 'rules' => 'required'],
            "price" => ["label" => "harga", 'rules' => 'required'],
            "status" => ["label" => "status", 'rules' => 'required'],
            "description" => ["label" => "deskripsi", 'rules' => 'required'],
        ];
        
        try {
            $photo = $this->request->getFile('photo');
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $rules["photo"] = [ 'label' => 'Image File', 'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'];
            }

            if ($this->validate($rules)) {
                $product = service("Products")->findOne([
                    ["where", "id", numeric($id)]
                ]);

                if(!$product) {
                    throw new Exception("Produk tidak ditemukan!");
                }
        
                $obj = new \stdClass();
                $obj->name =  $this->request->getPost('name');
                $obj->price =  $this->request->getPost('price');
                $obj->status =  $this->request->getPost('status');
                $obj->description =  $this->request->getPost('description');

                if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                    $file_name = upload_img($photo, $this->upload_path, [
                        ['fit', 720, 720, 'center'],
                    ]);
                    if($file_name) {
                        $obj->photo = $this->upload_path . $file_name;
                    }
                }

                service("Products")->update($product->id, $obj);

                return $this->response->setJSON([
                    "message" => "Produk diperbarui."
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
            $product = service("Products")->findOne([
                ["where", "id", $id]
            ]);
            if(!$product) {
                throw new Exception("Produk tidak ditemukan!");
            }
            service("Products")->delete($product->id);
            return $this->respond([
                "message" => "Produk dihapus"
            ]);
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage()
            ], 500);
        }
    }

}