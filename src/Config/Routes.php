<?php
$routes->group('', ['namespace' => 'Tatter\Users\Controllers'], function($routes)
{
	$routes->get( '/forgot',   'Users::forgot', ['as' => 'forgot']);
	$routes->post('/forgot',   'Users::forgot');

	$routes->get( '/login',    'Users::login', ['as' => 'login']);
	$routes->post('/login',    'Users::login');

	$routes->get( '/logout',   'Users::logout', ['as' => 'logout']);

	$routes->get( '/pending',  'Users::pending');
	$routes->post('/pending',  'Users::pending');

	$routes->get( '/register', 'Users::register', ['as' => 'register']);
	$routes->post('/register', 'Users::register');

	$routes->get( '/reset',    'Users::reset', ['as' => 'reset']);
	$routes->post('/reset',    'Users::reset');
	
	$routes->get( '/verify',   'Users::verify', ['as' => 'verify']);
});
