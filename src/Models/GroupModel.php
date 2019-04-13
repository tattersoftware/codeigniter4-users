<?php namespace Tatter\Users\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
	protected $table      = 'groups';
	protected $primaryKey = 'id';

	protected $returnType = 'Tatter\Users\Entities\Group';
	protected $useSoftDeletes = true;

	protected $allowedFields = [
		'name', 'deleted', 'deleted_at'
	];

	protected $useTimestamps = true;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
}
