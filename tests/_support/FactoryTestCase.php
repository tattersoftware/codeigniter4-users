<?php namespace Tests\Support;

use Tatter\Users\UserFactory;

class FactoryTestCase extends DatabaseTestCase
{
	/**
	 * The factory class to test.
	 *
	 * @var string
	 */
	protected $class;

	/**
	 * The model class to use for creating a faked database entity.
	 *
	 * @var string
	 */
	protected $faker;

	/**
	 * The test user created by the faker.
	 *
	 * @var object
	 */
	protected $user;

	/**
	 * The factory instance.
	 *
	 * @var UserFactory
	 */
	protected $factory;

	/**
	 * Sets up test instances
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$this->user    = fake($this->faker);
		$this->factory = new $this->class();
	}
}
