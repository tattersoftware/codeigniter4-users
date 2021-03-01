<?php namespace Tatter\Users;

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
	 * class to check availability.
	 *
	 * @var array<string,string>
	 */
	protected static $factories = [
		'Myth\Auth\Models\UserModel'     => Factories\MythFactory::class,
		'Sparks\Shield\Models\UserModel' => Factories\ShieldFactory::class,
		'Fluent\Auth\Models\UserModel'   => Factories\FluentFactory::class,
	];

	/**
	 * Returns the array of known factories
	 *
	 * @return array<string,string>
	 */
	public static function getFactories(): array
	{
		return static::$factories;
	}

	/**
	 * Sets the array of known factories.
	 *
	 * @param array<string,string> $factories
	 *
	 * @return void
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
		static::$factories = array_merge([$check => $factory], static::$factories);
	}
}
