<?php namespace Tatter\Users\Entities;

use CodeIgniter\Entity;

class Group extends Entity
{
	protected $id;
	protected $name;
	protected $deleted;
	protected $created_at;
	protected $updated_at;
	
	protected $dates = ['created_at', 'updated_at'];	
}
