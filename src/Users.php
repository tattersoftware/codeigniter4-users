<?php namespace Tatter\Users;

/***
* Name: Users
* Author: Matthew Gatner
* Contact: mgatner@tattersoftware.com
* Created: 2019-04-12
*
* Description:  Lightweight user authentication for CodeIgniter 4
*
* Requirements:
* 	>= PHP 7.1
* 	>= CodeIgniter 4.0
*	Preconfigured, autoloaded Database
*	`users`, `groups`, and `logins` tables (run migrations)
*
* Configuration:
* 	Use Config/Users.php to override default behavior
* 	Run migrations to update database tables:
* 		> php spark migrate:latest -all
*
* @package CodeIgniter4-Users
* @author Matthew Gatner
* @link https://github.com/tattersoftware/codeigniter4-users
*
***/

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Config\Services;
use Tatter\Users\Models\GroupModel;
use Tatter\Users\Models\UserModel;
//use Tatter\Users\Exceptions\UsersException;

/*** CLASS ***/
class Users
{
	/**
	 * Our configuration instance.
	 *
	 * @var \Tatter\Users\Config\Users
	 */
	protected $config;

	/**
	 * The main database connection
	 *
	 * @var ConnectionInterface
	 */
	protected $db;

	/**
	 * The active user session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * The group model
	 *
	 * @var \Tatter\Users\Models\GroupModel
	 */
	protected $groups;

	/**
	 * The user model
	 *
	 * @var \Tatter\Users\Models\UserModel
	 */
	protected $users;
	
	// initiate library, check for existing session
	public function __construct(BaseConfig $config)
	{
		// save configuration
		$this->config = $config;

		// initiate the Session library
		$this->session = Services::session();
		
		// load the models
		$this->groups = new GroupModel();
		$this->users = new UserModel();
		
		// If no db connection passed in, use the default database group.
		$this->db = db_connect($db);
	}
	
	// checks for a logged in user based on config
	// returns user ID, 0 for "not logged in", -1 for CLI
	public function sessionUserId(): int
	{
		if (is_cli())
			return -1;
		return $this->session->get($this->config->sessionUserId) ?? 0;
	}
}
