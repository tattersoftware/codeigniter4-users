<?php

use Sparks\Shield\Models\UserModel;
use Tatter\Users\Factories\ShieldFactory;
use Tatter\Users\UserEntity;
use Tests\Support\FactoryTestCase;

class ShieldFactoryTest extends FactoryTestCase
{
	protected $namespace = 'Sparks\Shield';
	protected $class     = ShieldFactory::class;
	protected $faker     = UserModel::class;

	public function testId()
	{
		$result = $this->factory->findById($this->user->id);

		$this->assertInstanceof(UserEntity::class, $result);
		$this->assertEquals($this->user->username, $result->getUsername());
	}
}
