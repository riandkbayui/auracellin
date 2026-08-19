<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Transactions extends BaseController {

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex(){
        try {
			$limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
			$page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
			$offset = ($page - 1) * $limit;
			$params = [];

			$user_id = userId();
			$params[] = ["where", "user_id", $user_id];

			$getTotal = service("Transactions")->findOne(array_merge($params, [
				["selectCount", "id", "total"]
			]));

			$params[] = ["orderBy", "created_at", "desc"];
			$params[] = ["select", ["id", "invoice", "total", "status", "description", "created_at"]];
			$params[] = ["limit", $limit, $offset];
			$results = service("Transactions")->findAll($params);

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

    public function postCreate() {
        $rules = [
            "products"     => ["label" => "produk", "rules" => "required"],
            "city_id"      => ["label" => "kota", "rules" => "required|numeric"],
            "full_address" => ["label" => "alamat lengkap", "rules" => "required"],
            "description"  => ["label" => "deskripsi", "rules" => "required"],
            "payment_photo" => ["label" => "bukti bayar", "rules" => "uploaded[payment_photo]|is_image[payment_photo]|mime_in[payment_photo,image/jpg,image/jpeg,image/png]"],
        ];

        try {
            if ($this->validate($rules)) {
                $photo = $this->request->getFile("payment_photo");
                
                // Simpan foto sementara atau langsung di proses service
                $data = [
                    "user_id"      => userId(),
                    "city_id"      => $this->request->getPost("city_id"),
                    "full_address" => $this->request->getPost("full_address"),
                    "description"  => $this->request->getPost("description"),
                    "products"     => json_decode(html_entity_decode($this->request->getPost("products")), true),
                    "payment_photo"=> $photo
                ];

                service("Transactions")->createTransaction($data);

                return $this->response->setJSON(["message" => "Transaksi berhasil dibuat."]);
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

    public function getDetail($id) {
        try {
            $transaction = service("Transactions")->findOne([
                ["where", "id", $id],
                ["where", "user_id", userId()]
            ]);

            if (!$transaction) {
                throw new Exception("Transaksi tidak ditemukan.");
            }

            $details = service("TransactionDetails")->findAll([
                ["where", "transaction_id", $transaction->id]
            ]);

            return $this->respond([
                "transaction" => $transaction,
                "details" => $details
            ]);
        } catch (\Throwable $th) {
            return $this->respond(["message" => $th->getMessage()], 500);
        }
    }

}