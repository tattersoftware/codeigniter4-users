<?php

use CodeIgniter\Test\CIDatabaseTestCase;
use Sparks\Shield\Models\UserModel;
use Tatter\Users\Factories\ShieldFactory;
use Tatter\Users\UserEntity;

class ShieldFactoryTest extends CIDatabaseTestCase
{
	/**
	 * The namespace(s) to help us find the migration classes.
	 * Empty is equivalent to running `spark migrate -all`.
	 * Note that running "all" runs migrations in date order,
	 * but specifying namespaces runs them in namespace order (then date)
	 *
	 * @var string|array|null
	 */
	protected $namespace = 'Sparks\Shield';

	public function testFactoryMethods()
	{
		$user = fake(UserModel::class);

		$factory = new ShieldFactory();
		$result  = $factory->findById($user->id);

		$this->assertInstanceof(UserEntity::class, $result);
		$this->assertEquals($user->username, $result->getUsername());
	}
}
