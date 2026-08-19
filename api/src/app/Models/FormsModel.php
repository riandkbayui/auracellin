<?php

namespace App\Models;

use CodeIgniter\Model;

class FormsModel extends Model {

	protected $table      = 'forms';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = ["slug","name","text_start","text_end","user_id","fields","phones","status","created_by","updated_by","deleted_by"];
	
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $dateFormat = 'datetime';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
}
