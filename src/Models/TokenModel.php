<?php namespace Tatter\Users\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
	protected $table      = 'tokens';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = false;

	protected $allowedFields = [
		'type', 'content', 'expired_at',
		'user_id', 'ip_address', 'agent'
	];

	protected $useTimestamps = true;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
}
