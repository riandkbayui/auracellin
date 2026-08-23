<?php

namespace App\Controllers\Api\Admin;
use App\Controllers\BaseController;
use Exception;

class Transactions extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function getIndex() {
        try {
            $limit = $this->request->getGet('limit', FILTER_SANITIZE_NUMBER_INT) ?? 5;
            $page = $this->request->getGet('page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
            $offset = ($page - 1) * $limit;
            $params = [];

            $getTotal = service("Transactions")->findOne(array_merge($params, [
                ["selectCount", "transactions.id", "total"]
            ]));

            $params[] = ["orderBy", "transactions.created_at", "desc"];
            $params[] = ["select", ["transactions.id", "transactions.invoice", "transactions.total", "transactions.status", "transactions.description", "transactions.created_at", "transactions.payment_photo"]];
            $params[] = ["limit", $limit, $offset];
            $results = service("Transactions")->findAll($params);

            if(!$results) {
                throw new Exception("Data kosong!");
            }

            $results = array_map(function($obj){
                if (!empty($obj->payment_photo)) {
                    $obj->payment_photo = base_url($obj->payment_photo);
                }
                return $obj;
            }, $results);

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

    public function getDetail($id) {
        try {
            $transaction = service("Transactions")->findOne([
                ["where", "id", $id]
            ]);

            if (!$transaction) {
                throw new Exception("Transaksi tidak ditemukan.");
            }

            if (!empty($transaction->payment_photo)) {
                $transaction->payment_photo = base_url($transaction->payment_photo);
            }

            $db = db_connect();
            $details = $db->table('transaction_details')
                ->select('transaction_details.*, products.name, products.photo, products.description as product_description')
                ->join('products', 'products.id = transaction_details.product_id', 'left')
                ->where('transaction_details.transaction_id', $transaction->id)
                ->where('transaction_details.deleted_at IS NULL')
                ->get()
                ->getResult();

            $details = array_map(function($obj){
                if (!empty($obj->photo)) {
                    $obj->photo = base_url($obj->photo);
                }
                return $obj;
            }, $details);

            $city = null;
            if (!empty($transaction->city_id)) {
                $city = $db->table('area_cities')->where('id', $transaction->city_id)->get()->getRow();
            }

            return $this->respond([
                "transaction" => $transaction,
                "details" => $details,
                "city" => $city
            ]);
        } catch (\Throwable $th) {
            return $this->respond(["message" => $th->getMessage()], 500);
        }
    }

    public function postUpdateStatus($id) {
        try {
            $status = $this->request->getPost('status');
            $tracking_number = $this->request->getPost('tracking_number');

            $transaction = service("Transactions")->findOne([
                ["where", "id", $id]
            ]);

            if (!$transaction) {
                throw new Exception("Transaksi tidak ditemukan.");
            }

            if ($transaction->status === 'completed' && $status !== 'completed') {
                throw new Exception("Status transaksi yang sudah completed tidak dapat diubah.");
            }

            $db = db_connect();
            $db->transStart();

            $data = [];
            if ($status) {
                $data['status'] = $status;
                if ($status === 'completed') {
                    $data['completed_at'] = date('Y-m-d H:i:s');
                }
            }
            if ($tracking_number !== null) {
                $data['tracking_number'] = $tracking_number;
            }

            if (!empty($data)) {
                service("Transactions")->update($id, $data);
            }

            if ($status === 'completed' && $transaction->status !== 'completed') {
                $details = $db->table('transaction_details')
                    ->where('transaction_id', $id)
                    ->where('deleted_at IS NULL')
                    ->get()
                    ->getResult();

                foreach ($details as $detail) {
                    $stockObj = new \stdClass();
                    $stockObj->product_id = $detail->product_id;
                    $stockObj->type = 'out';
                    $stockObj->qty = $detail->qty;
                    $stockObj->description = 'Penjualan Invoice ' . $transaction->invoice;
                    service("ProductStocks")->create($stockObj);
                }
            }

            $db->transComplete();
            if ($db->transStatus() === false) {
                throw new Exception("Gagal memperbarui status transaksi.");
            }

            return $this->response->setJSON([
                "message" => "Status transaksi berhasil diperbarui."
            ]);
        } catch (\Throwable $th) {
            return $this->response->setStatusCode(500)->setJSON([
                "message" => $th->getMessage()
            ]);
        }
    }

    public function postDelete() {
        try {
            $id = $this->request->getPost('id');
            $transaction = service("Transactions")->findOne([
                ["where", "id", $id]
            ]);
            if(!$transaction) {
                throw new Exception("Transaksi tidak ditemukan!");
            }
            service("Transactions")->delete($transaction->id);
            return $this->respond([
                "message" => "Transaksi berhasil dihapus."
            ]);
        } catch (\Throwable $th) {
            return $this->respond([
                "message" => $th->getMessage()
            ], 500);
        }
    }
}
