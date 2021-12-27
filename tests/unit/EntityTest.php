<?php

use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class EntityTest extends ProjectTestCase
{
    /**
     * Mock Entity data
     *
     * @var array<string,int|string>
     */
    private $data = [
        'id'       => 1,
        'username' => 'Artanis',
        'email'    => 'strength_in_unity@protoss.com',
        'active'   => 1,
    ];

    /**
     * @dataProvider entityProvider
     *
     * @param mixed $class
     */
    public function testEntityMethods($class)
    {
        $entity = new $class($this->data);

        $this->assertSame('id', $entity->getIdentifier());
        $this->assertSame($this->data['id'], $entity->getId());
        $this->assertSame($this->data['email'], $entity->getEmail());
        $this->assertSame($this->data['username'], $entity->getUsername());
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
