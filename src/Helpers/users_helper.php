<?php

/***
*
* Recommended usage:
*	1. Load the helper in BaseController: `helper('users')`
*	2. Use `auth()` or `auth($depth)` to initiate authentication
* 	3. Use `userId()` to get the ID of the current logged in user
***/

if (! function_exists('auth'))
{
	// initiate authentication, as configured in the library
	function auth(int $depth = 2)
	{
		$users = service('users');
		$users->authenticate($depth);
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
