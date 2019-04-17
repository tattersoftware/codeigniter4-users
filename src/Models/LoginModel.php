<?php namespace Tatter\Users\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
	protected $table      = 'logins';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = false;

	protected $allowedFields = [
		'login', 'user_id', 'ip_address', 'agent',
		'depth', 'impersonation', 'failed', 'created_at',
	];

	protected $useTimestamps = false;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;
}
