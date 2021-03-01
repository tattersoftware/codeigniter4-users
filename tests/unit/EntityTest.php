<?php

use Tests\Support\ProjectTestCase;

class EntityTest extends ProjectTestCase
{
	/**
	 * Mock Entity data
	 *
	 * @var array<string,string|int>
	 */
	private $data = [
		'id'       => 1,
		'username' => 'Artanis',
		'email'    => 'strength_in_unity@protoss.com',
		'active'   => 1,
	];

	/**
	 * @dataProvider entityProvider
	 */
	public function testEntityMethods($class)
	{
		$entity = new $class($this->data);

		$this->assertEquals('id', $entity->getIdentifier());
		$this->assertEquals($this->data['id'], $entity->getId());
		$this->assertEquals($this->data['email'], $entity->getEmail());
		$this->assertEquals($this->data['username'], $entity->getUsername());
		$this->assertTrue($entity->isActive());
		$this->assertNull($entity->getName());
	}

	public function entityProvider(): array
	{
		return [
			['Tatter\Users\Entities\MythEntity'],
			['Tatter\Users\Entities\ShieldEntity'],
			['Tatter\Users\Entities\FluentEntity'],
		];
	}
}
