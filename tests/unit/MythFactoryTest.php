<?php

use Myth\Auth\Test\Fakers\UserFaker;
use Tatter\Users\Factories\MythFactory;
use Tatter\Users\UserEntity;
use Tests\Support\FactoryTestCase;

class MythFactoryTest extends FactoryTestCase
{
	protected $namespace = 'Myth\Auth';
	protected $class     = MythFactory::class;
	protected $faker     = UserFaker::class;

	public function testId()
	{
		$result = $this->factory->findById($this->user->id);

		$this->assertInstanceof(UserEntity::class, $result);
		$this->assertEquals($this->user->username, $result->getUsername());
	}
}
