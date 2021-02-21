<?php

use CodeIgniter\Test\CIDatabaseTestCase;
use Myth\Auth\Test\Fakers\UserFaker;
use Tatter\Users\Factories\MythFactory;
use Tatter\Users\UserEntity;

class MythFactoryTest extends CIDatabaseTestCase
{
	/**
	 * The namespace(s) to help us find the migration classes.
	 * Empty is equivalent to running `spark migrate -all`.
	 * Note that running "all" runs migrations in date order,
	 * but specifying namespaces runs them in namespace order (then date)
	 *
	 * @var string|array|null
	 */
	protected $namespace = 'Myth\Auth';

	public function testFactoryMethods()
	{
		$user = fake(UserFaker::class);

		$factory = new MythFactory();
		$result  = $factory->findById($user->id);

		$this->assertInstanceof(UserEntity::class, $result);
		$this->assertEquals($user->username, $result->getUsername());
	}
}
