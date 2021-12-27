<?php

namespace Tests\Support;

use Tatter\Users\UserEntity;
use Tatter\Users\UserFactory;

abstract class FactoryTestCase extends DatabaseTestCase
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

	public function testId()
	{
		$result = $this->factory->findById($this->user->id);

		$this->assertInstanceof(UserEntity::class, $result);
		$this->assertSame($this->user->id, $result->getId());
	}

	public function testEmail()
	{
		// Shield's faker does not include email yet
		if ($this->faker === 'Sparks\Shield\Models\UserModel')
		{
			$this->markTestSkipped();
		}

		$result = $this->factory->findByEmail($this->user->email);

		$this->assertInstanceof(UserEntity::class, $result);
		$this->assertSame($this->user->id, $result->getId());
	}

	public function testUsername()
	{
		$result = $this->factory->findByUsername($this->user->username);

		$this->assertInstanceof(UserEntity::class, $result);
		$this->assertSame($this->user->id, $result->getId());
	}
}
