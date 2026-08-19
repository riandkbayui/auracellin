<?php

namespace App\Models;

use CodeIgniter\Model;

class WhatsappsModel extends Model {

	protected $table      = 'whatsapps';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = ["phone","message","created_by","updated_by","deleted_by"];
	
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $dateFormat = 'datetime';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
}
