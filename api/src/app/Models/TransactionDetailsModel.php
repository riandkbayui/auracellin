<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailsModel extends Model {

    protected $table      = 'transaction_details';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["transaction_id","product_id","price","qty","total","status","sent_at","completed_at","created_by","updated_by","deleted_by"];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $dateFormat    = 'datetime';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
