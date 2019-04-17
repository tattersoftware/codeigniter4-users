<?php namespace Tatter\Users\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table      = 'users';
	protected $primaryKey = 'id';

	protected $returnType = 'Tatter\Users\Entities\User';
	protected $useSoftDeletes = true;

	protected $allowedFields = [
		'username', 'firstname', 'lastname', 'email',
		'password', 'disabled', 'verified_at',
	];

	protected $useTimestamps = true;

	protected $validationRules    = [
		'username'     => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,{id}',
		'email'        => 'required|valid_email|is_unique[users.email,id,{id}]'
	];
	protected $validationMessages = [];
	protected $skipValidation     = false;
}
