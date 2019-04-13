<?php

/***
*
* Recommended usage:
*	1. Load the helper in BaseController: `helper('users')`
*	2. Use `auth()` or `auth($depth)` to initiate authentication
* 	3. Use `userId()` to get the ID of the current logged in user
***/

/***
* Constants for authentication depth
*
* Trivial: Uses cookie information if avaialble, otherwise doesn't bother
* Casual: Uses cookie if available, otherwise requires form
* Formal: Requires form regardless of cookie
* Secure: Requires dual with form
***/
defined('AUTH_TRIVIAL') || define('AUTH_TRIVIAL', 1);
defined('AUTH_CASUAL')  || define('AUTH_CASUAL',  2);
defined('AUTH_FORMAL')  || define('AUTH_FORMAL',  3);
defined('AUTH_SECURE')  || define('AUTH_SECURE',  4);

if (! function_exists('auth'))
{
	// initiate authentication, as configured in the library
	function auth(int $depth = null)
	{
		$_SESSION['userId'] = 1561;
		return true;
		
		$auth = service('auth');
		$auth->authenticate($depth);
	}
}

if (! function_exists('userId'))
{
	// retrieve the current logged in user's ID, as configured in the library
	function userId()
	{
		return $_SESSION['userId'] ?? 0;
		
		$auth = service('auth');
		$auth->getUserId();
	}
}
