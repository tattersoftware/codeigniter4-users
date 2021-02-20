<?php namespace Tatter\Interfaces\Config;

use CodeIgniter\Config\Factories;
use Config\Services as BaseServices;
use Tatter\Interfaces\User\UserFactory;
use Tatter\Interfaces\User\UserProvider;
use RuntimeException;

class Services extends BaseServices
{
	/**
	 * Locates a valid User Factory.
	 *
	 * @return UserFactory
	 *
	 * @throws RuntimeException If no factory is available
	 */
	public static function users(bool $getShared = true): UserFactory
	{
		if ($getShared)
		{
			return static::getSharedInstance('users');
		}

		// First check for a valid User Model
		if ($model = Factories::models('UserModel', ['instanceOf' => UserFactory::class]))
		{
			return $model;
		}

		// Use the provider to check for known factories
		foreach (UserProvider::getFactories() as $check => $factory)
		{
			if (class_exists($check))
			{
				return new $factory();
			}
		}

		throw new RuntimeException('Could not detect any UserFactory implementations.');
	}
}
