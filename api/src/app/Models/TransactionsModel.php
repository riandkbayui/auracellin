<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model {

    protected $table      = 'transactions';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ["invoice","tracking_number","payment_photo","delivery_photo","user_id","total","description","city_id","full_address","status","sent_at","completed_at","created_by","updated_by","deleted_by"];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $dateFormat    = 'datetime';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
