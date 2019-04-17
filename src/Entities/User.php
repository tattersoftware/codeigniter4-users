<?php namespace Tatter\Users\Entities;

use CodeIgniter\Entity;

class User extends Entity
{
	protected $id;
	protected $username;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $password;
	protected $disabled;
	protected $deleted;
	protected $created_at;
	protected $verified_at;
	protected $updated_at;
	
	protected $_options = [
		'dates' => ['created_at', 'verified_at', 'updated_at'],
		'casts' => [],
		'datamap' => []
	];
	
	// Automatically hashes the password when set.
	// https://github.com/lonnieezell/myth-auth/blob/develop/src/Entities/User.php
	// https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
	public function setPassword(string $password)
	{
		$this->password = password_hash(
			base64_encode(hash('sha512', $password, true)),
			PASSWORD_DEFAULT
		);
	}
}
