<?php

use Tatter\Users\UserProvider;
use Tests\Support\ProjectTestCase;

class ProviderTest extends ProjectTestCase
{
	public function testGetFactories()
	{
		$expected = [
			'Myth\Auth\Models\UserModel'     => 'Tatter\Users\Factories\MythFactory',
			'Sparks\Shield\Models\UserModel' => 'Tatter\Users\Factories\ShieldFactory',
		];

		$this->assertSame($expected, UserProvider::getFactories());
	}

	public function testSetFactories()
	{
		$expected = ['foo' => 'bar'];

		UserProvider::setFactories($expected);

		$this->assertSame($expected, UserProvider::getFactories());
	}

	public function testAddFactory()
	{
		$expected = [
			'foo'                            => 'bar',
			'Myth\Auth\Models\UserModel'     => 'Tatter\Users\Factories\MythFactory',
			'Sparks\Shield\Models\UserModel' => 'Tatter\Users\Factories\ShieldFactory',
		];

		UserProvider::addFactory('foo', 'bar');

		$this->assertSame($expected, UserProvider::getFactories());
	}
}
