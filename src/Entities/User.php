<?php namespace Tatter\Users\Entities;

use CodeIgniter\Entity;

class User extends Entity
{
	protected $id;
	protected $role;
	protected $username;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $phone;
	protected $password_hash;
	protected $reset_hash;
	protected $verify_hash;
	protected $deleted;
	protected $created_at;
	protected $verified_at;
	protected $updated_at;
	protected $deleted_at;
	
	protected $_options = [
		'dates' => ['created_at', 'verified_at', 'updated_at', 'deleted_at'],
		'casts' => [],
		'datamap' => []
	];
	
}
