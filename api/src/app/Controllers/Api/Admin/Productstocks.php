<?php

namespace App\Controllers\Api\Admin;
use App\Controllers\BaseController;
use Exception;

class Productstocks extends BaseController {

    public function getIndex() {
        try {
            $product_id = $this->request->getGet('product_id', FILTER_SANITIZE_NUMBER_INT);
            $limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 10;
            $page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
            $offset = ($page - 1) * $limit;
            $params = [];

            if ($product_id) {
                $params[] = ["where", "product_id", $product_id];
            }

            $getTotal = service("ProductStocks")->findOne(array_merge($params, [
                ["selectCount", "product_stocks.id", "total"]
            ]));

            $params[] = ["orderBy", "product_stocks.created_at", "desc"];
            $params[] = ["select", ["products.name", "product_stocks.type", "product_stocks.created_at", "product_stocks.qty", "product_stocks.description", "product_stocks.id"]];
            $params[] = ["join", "products", "products.id = product_stocks.product_id", "left"];
            $params[] = ["limit", $limit, $offset];
            $results = service("ProductStocks")->findAll($params);

            if(!$results) {
                throw new Exception("Data kosong!");
            }

            $hasNext = ($offset + count($results)) < $getTotal->total;

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
            "product_id"  => ["label" => "produk", 'rules' => 'required|numeric'],
            "type"        => ["label" => "tipe", 'rules' => 'required|in_list[in,out]'],
            "qty"         => ["label" => "jumlah", 'rules' => 'required|numeric'],
            "description" => ["label" => "deskripsi", 'rules' => 'required'],
        ];
        
        try {
            if ($this->validate($rules)) {
                $obj = new \stdClass();
                $obj->product_id  = $this->request->getPost('product_id');
                $obj->type        = $this->request->getPost('type');
                $obj->qty         = $this->request->getPost('qty');
                $obj->description = $this->request->getPost('description');

                service("ProductStocks")->create($obj);

                return $this->response->setJSON([
                    "message" => "Mutasi stok ditambahkan."
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
            $stock = service("ProductStocks")->findOne([
                ["where", "id", $id]
            ]);
            if(!$stock) {
                throw new Exception("Data mutasi tidak ditemukan!");
            }
            service("ProductStocks")->delete($stock->id);
            return $this->respond([
                "message" => "Data mutasi dihapus"
            ]);
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage()
            ], 500);
        }
    }
}