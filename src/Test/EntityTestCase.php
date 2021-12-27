<?php

namespace Tatter\Users\Test;

use CodeIgniter\Test\CIUnitTestCase;
use RuntimeException;
use Tatter\Users\Interfaces\HasGroup;
use Tatter\Users\Interfaces\HasPermission;
use Tatter\Users\UserEntity;

/**
 * @codeCoverageIgnore
 */
abstract class EntityTestCase extends CIUnitTestCase
{
    /**
     * The entity class to test.
     *
     * @var class-string<UserEntity>
     */
    protected $class;

    /**
     * The entity instance.
     *
     * @var UserEntity
     */
    protected $entity;

    /**
     * Mock Entity data
     *
     * @var array<string,bool|int|string>
     */
    protected $data = [
        'name'     => 'Rubick, the Grand Magus',
        'username' => 'rubick',
        'email'    => 'spellbandit@dota.gg',
        'active'   => true,
    ];

    /**
     * The field identifier used by this entity.
     *
     * @var string
     */
    protected $identifier = 'id';

    /**
     * Sets up the test instances.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->data[$this->identifier] = 1;

        $this->entity = new $this->class($this->data);
    }

    /**
     * Creates the scenario for entities that implement HasGroup
     * to verify the following checks:
     *  - $this->entity->hasGroup('dire') === false
     *  - $this->entity->hasGroup('radiant') === true
     */
    protected function setUpGroups(HasGroup $entity): void
    {
        throw new RuntimeException('You must provide a setUpGroup() method to test HasGroup entities.');
    }

    /**
     * Creates the scenario for entities that implement HasPermission
     * to verify the following checks:
     *  - $this->entity->hasPermission('creeps.lastHit') === false
     *  - $this->entity->hasPermission('camps.stack') === true
     */
    protected function setUpPermissions(HasPermission $entity): void
    {
        throw new RuntimeException('You must provide a setUpPermissions() method to test HasGroup entities.');
    }

    //--------------------------------------------------------------------

    public function testGetIdentifier()
    {
        $this->assertSame($this->identifier, $this->entity->getIdentifier());
    }

    public function testGetId()
    {
        $this->assertSame($this->data[$this->identifier], $this->entity->getId());

        unset($this->entity->{$this->identifier});
        $this->assertNull($this->entity->getId());
    }

    public function testGetEmail()
    {
        $this->assertSame($this->data['email'], $this->entity->getEmail());

        unset($this->entity->email);
        $this->assertNull($this->entity->getEmail());
    }

    public function testGetUsername()
    {
        $this->assertSame($this->data['username'], $this->entity->getUsername());

        unset($this->entity->username);
        $this->assertNull($this->entity->getUsername());
    }

    public function testGetName()
    {
        $this->assertSame($this->data['name'], $this->entity->getName());

        unset($this->entity->name);
        $this->assertNull($this->entity->getName());
    }

    /**
     * @dataProvider activeProvider
     *
     * @param mixed $input
     */
    public function testIsActive($input, bool $result)
    {
        $this->data['active'] = $input;
        $entity               = new $this->class($this->data);

        $this->assertSame($result, $entity->isActive());
    }

    public function activeProvider()
    {
        return [
            [true, true],
            [1, true],
            ['1', true],
            [false, false],
            [0, false],
            ['0', false],
            [null, false],
        ];
    }

    public function testHasGroup()
    {
        if (! $this->entity instanceof HasGroup) {
            $this->markTestSkipped($this->class . ' does not implement HasGroup.');
        }

        /** @var HasGroup $entity */
        $entity = $this->entity;

        $this->setUpGroups($entity);

        $this->assertFalse($entity->hasGroup('dire'));
        $this->assertTrue($entity->hasGroup('radiant'));
    }

    /**
     * Note: This test should include checks for Group permissions.
     */
    public function testHasPermission()
    {
        if (! $this->entity instanceof HasPermission) {
            $this->markTestSkipped($this->class . ' does not implement HasPermission.');
        }

        /** @var HasPermission $entity */
        $entity = $this->entity;

        $this->setUpPermissions($entity);

        $this->assertFalse($entity->hasPermission('creeps.lastHit'));
        $this->assertTrue($entity->hasPermission('camps.stack'));
    }
}
