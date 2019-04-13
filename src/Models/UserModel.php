<?php namespace Tatter\Users\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table      = 'users';
	protected $primaryKey = 'id';

	protected $returnType = 'Tatter\Users\Entities\User';
	protected $useSoftDeletes = true;

	protected $allowedFields = [ ];

	protected $useTimestamps = true;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;
	
	// https://github.com/lonnieezell/myth-auth/blob/develop/src/Authorization/GroupModel.php
	public function groups($userId = null): array
	{
		return $this->builder()
			->select('groups.id')
			->join($this->groupsPivot, "{$this->groupsPivot}.{$this->pivotKey} = {$this->table}.{$this->primaryKey}", 'left')
			->join('groups', "{$this->groupsPivot}.group_id = groups.id", 'left')
			->where("{$this->groupsPivot}.{$this->pivotKey}", $userId)
			->get()->getResultObject();
	}
}
