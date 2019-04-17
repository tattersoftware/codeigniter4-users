<?php namespace Tatter\Users\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Config\Services;
use Tatter\Users\Entities\User;

class Users extends Controller
{
	public function __construct()
	{
		// get the library instance
		$this->users = Services::users();
	}
	
	public function forgot()
	{
		
		return $this->users->view('forgot');
	}
	
	public function login()
	{
		if (! $this->request->getPost('users_login'))
			return $this->users->view('login');
	
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

		// attempt to match a user
		$user = $this->users->attempt($credentials);
		
		if (! $user)
			return redirect()
				->back()
				->withInput()
				->with('errors', $this->users->getMessages());

		// login the user
		$this->users->login($user, AUTH_FORMAL);
		
		// if 'remember' was requested then add the cookie
        if ($this->request->getPost('remember'))
        	$this->users->remember($user);
		// otherwise clear the cookie
		else
			$this->users->remember();
		
		$this->users->redirect();
	}
	
	public function pending()
	{
		if (! $this->request->getPost('users_pending'))
			return $this->users->view('pending');
		
		return $this->users->view('pending');
	}
	
	public function register()
	{
		if (! $this->request->getPost('users_register'))
			return $this->users->view('register');
	
		$rules = [
			'username'   => 'required|min_length[3]|alpha_dash',
			'email'      => 'required|valid_email',
			'password'   => 'required|min_length[8]',
			'robots'     => 'required|equals[' . session('robots') . ']',
		];
		
		if (! $this->validate($rules))
			return redirect()
				->back()
				->withInput()
				->with('errors', $this->validator->getErrors());

		$user = new User();
		$user->fill($this->request->getPost());
		$user = $this->users->register($user);
		
		// check if registration failed
		if (! $user)
			return redirect()
				->back()
				->withInput()
				->with('errors', $this->users->getMessages());
			
		// if verification is required show pending message
		if (! $user->verified_at)
			return $this->users->view('pending');
		
		// verified accounts are logged in immediately, so return to originating URL
		$this->users->redirect();		
	}
	
	public function reset()
	{
		return $this->users->view('reset');
	}
}
