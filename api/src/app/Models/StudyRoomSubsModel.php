<?php

namespace App\Models;

use CodeIgniter\Model;

class StudyRoomSubsModel extends Model {

	protected $table      = 'study_room_subs';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = ["code","package_id","study_room_id","url","name","description","status","created_by","updated_by","deleted_by"];
	
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $dateFormat = 'datetime';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
}
