<?php namespace Tatter\Interfaces\User;

/**
 * User Provider Class
 *
 * Provides automatic discovery
 * of known User Factories.
 */
class UserProvider
{
	/**
	 * Known factories. Keys are the
	 * class to check for to validate.
	 *
	 * @var array<string,string>
	 */
	protected static $factories = [
		'Myth\Auth\Models\UserModel'     => Factories\MythFactory::class,
		'Sparks\Shield\Models\UserModel' => Factories\ShieldFactory::class,
	];

	/**
	 * Returns the array of known factories
	 *
	 * @return string[]
	 */
	public static function getFactories(): array
	{
		return static::$factories;
	}

	/**
	 * Sets the array of known factories.
	 *
	 * @param array<string,string>
	 */
	public static function setFactories(array $factories): void
	{
		static::$factories = $factories;
	}

	/**
	 * Prepends a new factory, giving it priority.
	 *
	 * @param string $factory
	 *
	 * @return void
	 */
	public static function addFactory(string $check, string $factory): void
	{
		array_unshift(static::$factories, $factory);
	}
}
