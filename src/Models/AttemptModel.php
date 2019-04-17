<?php namespace Tatter\Users\Models;

use CodeIgniter\Model;

class AttemptModel extends Model
{
	protected $table      = 'attempts';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = false;

	protected $allowedFields = [
		'status', 'login', 'user_id', 'ip_address', 'agent', 'created_at',
	];

	protected $useTimestamps = false;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;
}
