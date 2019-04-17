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
* 	Cookie Helper (loaded automatically)
*	Various tables (run migrations)
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
use CodeIgniter\Events\Events;
use Tatter\Users\Entities\User;
//use Tatter\Users\Exceptions\UsersException;

/***
* Constants for authentication depth
*
* Trivial: Uses cookie information if available, otherwise doesn't bother
* Casual:  Uses cookie if available, otherwise requires form
* Formal:  Requires form regardless of cookie
* Secure:  Requires dual with form
***/
defined('AUTH_TRIVIAL') || define('AUTH_TRIVIAL', 1);
defined('AUTH_CASUAL')  || define('AUTH_CASUAL',  2);
defined('AUTH_FORMAL')  || define('AUTH_FORMAL',  3);
defined('AUTH_SECURE')  || define('AUTH_SECURE',  4);

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
	 * ID of current logged in user
	 *
	 * @var int
	 */
	protected $userId;

	/**
	 * Depth of current login
	 *
	 * @var \Tatter\Users\Entities\User
	 */
	protected $depth;

	/**
	 * Status of the last action
	 *
	 * @var string
	 */
	protected $status;

	/**
	 * Messages for the user from the last action
	 *
	 * @var array
	 */
	protected $messages;

	/**
	 * Errors for the user from the last action
	 *
	 * @var array
	 */
	protected $errors;
	
	// initiate library, check for existing session
	public function __construct(BaseConfig $config, $db = null)
	{
		// save configuration
		$this->config = $config;

		// initiate the Session library
		$this->session = Services::session();
		
		// initialize the cookie helper
		helper('cookie');
		
		// load the models
		$this->attempts = new Models\AttemptModel();
		$this->groups   = new Models\GroupModel();
		$this->logins   = new Models\LoginModel();
		$this->tokens   = new Models\TokenModel();
		$this->users    = new Models\UserModel();
		
		// If no db connection passed in, use the default database group.
		$this->db = db_connect($db);

		// special case for CLI requests
		if ( is_cli() ):
			$this->userId = -1;
			$this->userDepth = AUTH_SECURE;
			return;
		endif;
		
		// check for an existing session
		$this->userId = $this->session->userId ?? 0;
		$this->depth = $this->session->userDepth ?? 0;
	}
	
	// returns user ID, 0 for "not logged in", -1 for CLI
	public function userId(): int
	{
		return $this->userId;
	}
	
	// returns messages
	public function getMessages(): array
	{
		return $this->messages;
	}

	// returns status
	public function getStatus(): string
	{
		return $this->status;
	}
	
	// registers a new user
	public function register($user)
	{
		// check if verification is required
		if ($this->config->verifyMethod == 'none')
			$user->verified_at = date('Y-m-d H:i:s');

		// add to the database
		$userId = $this->users->insert($user);
		
		// make sure all went well
		if (empty($userId)):
			$this->status = 'error';
			$this->messages = $this->users->errors();
			return false;
		endif;
		
		// get the new user
		$user = $this->users->find($userId);
		
		// notify log & event
		log_message('debug', "Tatter\\Users :: User #{$user->id} '{$row->username}' successfully registered");
		Events::trigger('register', $user);
		
		// if email verification is required, send the email
		if ($this->config->verifyMethod == 'email')
			$this->email('verify', $user);
		// otherwise login the user
		else
			$this->login($user, AUTH_FORMAL);
				
		return $user;
	}
	
	// attempt to match a user by form credentials [field, login, password]
	public function attempt($credentials)
	{
		// save the url
		$this->session->returnTo = $this->session->returnTo ?? current_url();
		
		// record the attempt
		$request = Services::request();
		$row = [
			'status'      => 'attempt',
			'login'       => $credentials['login'],
			'ip_address'  => ip2long($request->getIPAddress()),
			'agent'       => (string)$request->getUserAgent(),
		];
		$attemptId = $this->attempts->insert($row);
		$attempt = $this->attempts->find($attemptId);

		// shouldn't happen
		if (! in_array($credentials['field'], ['email', 'username']) ):
			// log the error
			$error = lang('Users.missingLoginField', $depth);
			$this->status = 'error';
			$this->messages[] = $error;
			log_message('error', "Tatter\\Users :: {$error}");
			
			// check whether to throw
			if ($this->config->silent):
				return false;
			else:
				throw UsersException::forMissingLoginField();
			endif;
		endif;
		
		// try to find the user
		$user = $this->users
			->where($credentials['field'], $credentials['login'])
			->first();
				
		// no user matched
		if (empty($user))
			return $this->failure($attempt, 'userNotFound', $credentials['field']);
		
		// add the user ID to the attempt
		$attempt->user_id = $user->id;
		
		// verify password
		$result = password_verify(
			base64_encode(hash('sha512', $credentials['password'], true)),
			$user->password
		);
		if (! $result)
			return $this->failure($attempt, 'invalidPassword');
		
        // https://github.com/lonnieezell/myth-auth/blob/develop/src/Authentication/LocalAuthenticator.php
		// Check to see if the password needs to be rehashed due to the hash algorithm or hash
        // cost changing since the last time that a user logged in.
		if (password_needs_rehash($user->password, PASSWORD_DEFAULT)):
			$user->password = $credentials['password'];
			$this->users->save($user);
		endif;
		
		// check if user is disabled
		if ($user->disabled)
			return $this->failure($attempt, 'accountDisabled');
		
		// make sure account is verified
		if ($this->config->verifyMethod && ! $user->verified_at)
			return $this->failure($attempt, 'accountUnverified');
		
		// update the attempt record
		$attempt->status = 'success';
		$this->attempts->save($attempt);
		
		return $user;
	}
	
	// handles failed form attempts
	protected function failure($attempt, $errorName, ...$arguments)
	{
		// update the attempt record
		$attempt->status = $errorName;
		$this->attempts->save($attempt);
		
		// set class variables
		$this->status = 'error';
		$this->messages[] = lang("Users.{$errorName}", $arguments);

		return false;
	}
	
	// sets the logged in user; $user should be verified and not disabled
	protected function login($user, int $depth)
	{
		// update class properties
		$this->userId = $user->id;
		$this->userDepth = $depth;
		$this->status = 'success';
		$this->messages[] = lang('Users.userLoggedIn');
		
		// record the login
		$request = Services::request();
		$row = [
			'user_id'          => $user->id,
			'ip_address'       => ip2long($request->getIPAddress()),
			'agent'            => (string)$request->getUserAgent(),
			'depth'            => $depth,
			'impersonated_by'  => ($this->session->userId == $user->id)? null : $this->session->userId,
		];
		$loginId = $this->logins->insert($row);
		
		// update the session
		$this->session->userId = $user->id;
		$this->session->depth = $depth;

		// trigger login event, not that anyone cares
		Events::trigger('login', $user, $depth);
		
		return $user;
	}
		
	// resets class variables, removes session variables, removes cookie
	public function logout()
	{
		// store user ID for event trigger
		$userId = $this->userId;
		
		$this->userId = FALSE;
		$this->depth = 0;
		
		$this->session->remove('userId');
		$this->session->remove('userDepth');
		delete_cookie('tatter.users');
		
		$this->status = 'success';
		$this->messages[] = lang('Users.userLoggedOut');
		
		// trigger logout event
		Events::trigger('logout', $userId);
	}
		
	// returns to the page that requested the authentication
	public function redirect()
	{
		$url = $this->session->returnTo ?? base_url();
		$this->session->remove('returnTo');
		redirect()->to($url);
	}
	
	// stores/removes login cookies using a token
	public function remember($user = null)
	{
		// if no user was passed then remove the cookie
		if (empty($user))
			return delete_cookie('tatter.users');
		
		// create the hash
		$content = hash('sha256', bin2hex(random_bytes(20)) );
		set_cookie('tatter.users', $content, $this->config->rememberFor);
		
		// store the token
		$row = [
			'type'        => 'remember',
			'content'     => $content,
			'user_id'     => $user->id,
			'ip_address'  => ip2long($request->getIPAddress()),
			'agent'       => (string)$request->getUserAgent(),
			'expired_at'  =>  date('Y-m-d H:i:s', time() + $this->config->rememberFor),
		];
		$this->tokens->insert($row);
	}
	
	public function authenticate(int $depth = 2): bool
	{
		// reset status
		$this->status = 'success';
		$this->messages = [ ];
		$this->errors = [ ];
		
		// check for adequate existing session
		if ($this->userId && $this->depth<=$depth)
			return $this->userId;
		
		// handle request by depth
		switch ($depth):

			// attempt cookie and quit
			case AUTH_TRIVIAL: return $this->cookie(); break;

			// attempt cookie, fall back to username/password
			case AUTH_CASUAL: return $this->cookie() ?: $this->view('login'); break;
		
			// attempt form
			case AUTH_FORMAL: return $this->view('login'); break;
					
			// attempt dual
			case AUTH_SECURE: return $this->dual(); break;

			// error out by default		
			default:
				// log the error
				$error = lang('Users.invalidDepth', $depth);
				$this->status = 'error';
				$this->messages[] = $error;
				log_message('error', "Tatter\\Users :: {$error}");
				
				// check whether to throw
				if ($this->config->silent):
					return false;
				else:
					throw UsersException::forInvalidDepth();
				endif;
		endswitch;
	}
	
	// use encrypted cookie content to match a user
	protected function cookie()
	{		
		// check for existing cookie
		$content = get_cookie('tatter.users');
		
		// no cookie found
		if ($content === null)
			return false;

		// lookup token by cookie content
		$tokens = new TokenModel();
		$token = $tokens
			->where('type', 'remember')
			->where('content', $content)
			->where('expired_at <', date('Y-m-d H:i:s'))
			->first();
		
		// no matched tokens
		if (empty($token))
			return false;
		
		// get this token's user
		$user = $this->users->find($token->user_id);
		if (empty($user) || $user->disabled)
			return false;
		
		// login the corresponding user
		$this->login($user->id, AUTH_CASUAL);
		
		return true;
	}
	
	// WIP
	protected function dual()
	{
		throw UsersException::forUnsupportedMethod('Dual');
	}
	
	// display the requested view (with header & footer)
	public function view($name, $data = [])
	{		
		// load each view
		foreach (['header', $name, 'footer'] as $view):
			if (! empty($view)):
				echo view($this->config->views[$view], $data);
			endif;
		endforeach;
	}
	
	// sends the specified user a pre-composed email
	// conditional token creation
	private function email($type, $user)
	{
		// make sure this type of email is supported
		if (empty($this->config->emails[$type]))
			return false;

		log_message('debug', "Tatter\\Users :: Sending {$type} email to {$user->email}");
		
		// check if a token is needed
		if (in_array($type, ['verify', 'reset'])):
		
			// create the hash
			$content = hash('sha256', bin2hex(random_bytes(20)) );
		
			// store the token
			$row = [
				'type'        => $type,
				'content'     => $content,
				'user_id'     => $user->id,
				'ip_address'  => ip2long($request->getIPAddress()),
				'agent'       => (string)$request->getUserAgent(),
				'expired_at'  =>  date('Y-m-d H:i:s', time() + $this->config->tokenLife),
			];
			$this->tokens->insert($row);
			
			// create the link
			$url = route_to($type);
		endif;
		
		// compose the message based on configured view
		$message = view($this->config->emails[$type], ['url'=>$url]);
		
/*** WIP - awaiting CI4 Email library

		// load precofigured email settings from application/config/email.php
		$this->CI->load->library('email');
		$this->CI->email->from($from);
		$this->CI->email->to($user['email']);
		$this->CI->email->subject(ucfirst($type)." your account");
		$this->CI->email->message($message);
		$result = $this->CI->email->send(false);
		
		// check for errors
		if ($result===FALSE):
			$errors = $this->CI->email->print_debugger(array('headers'));
			log_message("error", "AuthCI->Email() :: Email failed to send: ".$errors);
			return FALSE;
		endif;
***/

		return true;
	}
}
