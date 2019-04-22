<?php namespace Tatter\Users\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Config\Services;
use Tatter\Users\Entities\User;
use Tatter\Users\Models\AttemptModel;
use Tatter\Users\Models\UserModel;

class Users extends Controller
{
	public function __construct()
	{
		// get the library instance
		$this->users = Services::users();
		$this->config = $this->users->getConfig();
		
		// start the session
		$this->session = session();
	}
	
	public function forgot()
	{
		
		return $this->users->view('forgot');
	}
	
	public function login()
	{
		// if no post data submitted then display the form and quit
		if (! $this->request->getPost('users_login'))
			return view($this->config->views['login'], ['config' => $this->config]);
	
		$rules = [
			'login'    => 'required|min_length[3]',
			'password' => 'required|min_length[8]',
		];
		
		if (! $this->validate($rules))
			return redirect()
				->back()
				->withInput()
				->with('errors', $this->validator->getErrors());
		
		$credentials['login'] = $this->request->getPost('login');
        $credentials['password'] = $this->request->getPost('password');
		
		// check if user supplied an email address or username
		$credentials['field'] = (filter_var($credentials['login'], FILTER_VALIDATE_EMAIL))?
			'email' : 'username';

		// record the attempt
		$attempts = new AttemptModel();
		$request = Services::request();
		$row = [
			'status'      => 'attempt',
			'login'       => $credentials['login'],
			'ip_address'  => ip2long($request->getIPAddress()),
			'agent'       => (string)$request->getUserAgent(),
			'created_at'       => date('Y-m-d H:i:s'),
		];
		$attemptId = $attempts->insert($row);
		$attempt = $attempts->find($attemptId);
		
		// try to find the user
		$users = new UserModel();
		$user = $users
			->where($credentials['field'], $credentials['login'])
			->first();

		// no user matched
		if (empty($user)):
			// update the attempt record
			$errorName = 'userNotFound';
			$attempt->status = $errorName;
			$attempts->save($attempt);
			
			return redirect()
				->back()
				->withInput()
				->with('errors', [$credentials['field'] => lang("Users.{$errorName}", $credentials['field'])] );
		endif;
		// add the user ID to the attempt
		$attempt->user_id = $user->id;
		
		// verify password
		$result = password_verify(
			base64_encode(hash('sha512', $credentials['password'], true)),
			$user->password
		);
		if (! $result):
			// update the attempt record
			$errorName = 'invalidPassword';
			$attempt->status = $errorName;
			$attempts->save($attempt);
			
			return redirect()
				->back()
				->withInput()
				->with('errors', ['password' => lang("Users.{$errorName}")] );
		endif;
		
        // https://github.com/lonnieezell/myth-auth/blob/develop/src/Authentication/LocalAuthenticator.php
		// Check to see if the password needs to be rehashed due to the hash algorithm or hash
        // cost changing since the last time that a user logged in.
		if (password_needs_rehash($user->password, PASSWORD_DEFAULT)):
			$user->password = $credentials['password'];
			$users->save($user);
		endif;
		
		// check if user is disabled
		if ($user->disabled):
			// update the attempt record
			$errorName = 'accountDisabled';
			$attempt->status = $errorName;
			$attempts->save($attempt);
			
			return redirect()
				->back()
				->withInput()
				->with('errors', [lang("Users.{$errorName}")] );
		endif;
				
		// make sure account is verified
		if ($this->config->verifyMethod && ! $user->verified_at):
			// update the attempt record
			$errorName = 'accountUnverified';
			$attempt->status = $errorName;
			$attempts->save($attempt);
			
			return redirect()
				->back()
				->withInput()
				->with('errors', [lang("Users.{$errorName}")] );
		endif;
		
		// update the attempt record
		$attempt->status = 'success';
		$attempts->save($attempt);

		// login the user
		$this->users->login($user, AUTH_FORMAL);
		
		// if 'remember' was requested then add the cookie
        if ($this->request->getPost('remember'))
        	$this->users->remember($user);
		// otherwise clear the cookie
		else
			$this->users->remember();
		
		// send back to original destination
		$url = $this->session->returnTo ?? base_url();
		$this->session->remove('returnTo');
		return redirect()->to($url);
	}
	
	public function logout()
	{
		$this->users->logout();
		return redirect()->back();
	}
	
	public function pending()
	{
		if (! $this->request->getPost('users_pending'))
			return $this->users->view('pending');
		
		return $this->users->view('pending');
	}
	
	public function register()
	{
		// if no post data submitted then display the form and quit
		if (! $this->request->getPost('users_register'))
			return view($this->config->views['register'], ['config' => $this->config]);
				
		// validate input	
		$rules = [
			'username'   => 'required|min_length[3]|alpha_dash',
			'email'      => 'required|valid_email',
			'password'   => 'required|min_length[8]',
			'human'      => 'required|equals[' . $this->session->human . ']',
		];
		if (! $this->validate($rules))
			return redirect()
				->back()
				->withInput()
				->with('errors', $this->validator->getErrors());
		
		// create a new user from the post values
		$user = new User();
		$user->fill($this->request->getPost());
		
		// check if verification is required
		if ($this->config->verifyMethod == 'none')
			$user->verified_at = date('Y-m-d H:i:s');

		// add to the database
		$users = new UserModel();
		$userId = $users->insert($user);
		
		// make sure all went well
		if (empty($userId))
			return redirect()
				->back()
				->withInput()
				->with('errors', $users->errors());
		
		// get the new user
		$user = $this->users->find($userId);
		
		// notify log & event
		log_message('debug', "Tatter\\Users :: User #{$user->id} '{$user->username}' successfully registered");
		Events::trigger('register', $user);
		
		// if user is verified, login and send back
		if ($user->verified_at):
			$this->users->login($user, AUTH_FORMAL);
			$url = $this->session->returnTo ?? base_url();
			$this->session->remove('returnTo');
			return redirect()->to($url);
					
		// if email verification is required, send the email
		elseif ($this->config->verifyMethod == 'email'):
			$this->users->email('verify', $user);
		endif;
			
		// show pending message
		return view($this->config->views['pending'], ['config' => $this->config, 'user' => $user]);
	}
	
	public function reset()
	{
		return $this->users->view('reset');
	}
}
