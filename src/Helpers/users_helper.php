<?php

/***
*
* Recommended usage:
*	1. Load the helper in BaseController: `helper('users')`
*	2. Use `auth()` or `auth($depth)` to check authentication
* 	3. Use `userId()` to get the ID of the current logged in user
***/

if (! function_exists('auth'))
{
	// check authentication, as configured in the library
	function auth(int $depth = 2)
	{
		// save the current URL to return to
		session()->set('returnTo', current_url());
		$users = service('users');
		return $users->authenticate($depth);
	}
}

if (! function_exists('userId'))
{
	// retrieve the current logged in user's ID, as configured in the library
	function userId()
	{
		$users = service('users');
		$users->userId();
	}
}

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
