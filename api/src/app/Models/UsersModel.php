<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model {

	protected $table      = 'users';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = ["sponsor_user_id","package_id","group","photo","name","username","phone","email","address","status","password","created_by","updated_by","deleted_by"];
	
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $dateFormat = 'datetime';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
}
