<?php namespace Tatter\Users\Config;

use CodeIgniter\Config\BaseConfig;

class Users extends BaseConfig
{
	// key in $_SESSION that contains the integer ID of a logged in user
	public $sessionUserId = "userId";

	// whether to continue instead of throwing exceptions
	public $silent = true;
	
	// method of verifying new user accounts
	// none, email, manual
	public $verifyMethod = 'email';
	
	// views to display for each function
	public $views = [
		'header'    => 'Tatter\Users\Views\header',
		'footer'    => 'Tatter\Users\Views\footer',
		'forgot'    => 'Tatter\Users\Views\forgot',
		'login'     => 'Tatter\Users\Views\login',
		'pending'   => 'Tatter\Users\Views\pending',
		'register'  => 'Tatter\Users\Views\register',
		'reset'     => 'Tatter\Users\Views\reset',	
	];
	
	// emails for various occasions
	public $emails = [
		'verify'  => 'Tatter\Users\Views\Emails\verify',
		'reset'   => 'Tatter\Users\Views\Emails\reset',	
	];

	// number of seconds for remembered logins to persist
	public $rememberFor = 30 * DAY;

	// time-to-live for tokens (password resets, account verifications)
	public $tokenLife = 3 * DAY;
}
