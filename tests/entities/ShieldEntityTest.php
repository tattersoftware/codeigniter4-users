<?php

use CodeIgniter\Test\DatabaseTestTrait;
use Sparks\Shield\Models\UserModel;
use Tatter\Users\Entities\ShieldEntity;
use Tatter\Users\Interfaces\HasGroup;
use Tatter\Users\Interfaces\HasPermission;
use Tatter\Users\Test\EntityTestCase;

/**
 * @internal
 */
final class ShieldEntityTest extends EntityTestCase
{
    // Email is an external table for Shield so we need the database
    use DatabaseTestTrait;

    protected $namespace = 'Sparks\Shield';
    protected $class     = ShieldEntity::class;

    /**
     * Creates the scenario for entities that implement HasGroup
     * to verify the following checks:
     *  - $this->entity->hasGroup('dire') === false
     *  - $this->entity->hasGroup('radiant') === true
     *
     * @param ShieldEntity $entity
     */
    protected function setUpGroups(HasGroup $entity): void
    {
        config('AuthGroups')->groups['radiant'] = [
            'title'       => 'The Radiant',
            'description' => 'The bottom left half of the game map.',
        ];

        // The foreign key requires us to create the user record as well
        model(UserModel::class)->insert($entity);

        $entity->addGroup('radiant');
    }

    /**
     * Creates the scenario for entities that implement HasPermission
     * to verify the following checks:
     *  - $this->entity->hasPermission('creeps.lastHit') === false
     *  - $this->entity->hasPermission('camps.stack') === true
     *
     * @param ShieldEntity $entity
     */
    protected function setUpPermissions(HasPermission $entity): void
    {
        config('AuthGroups')->permissions['camps.stack'] = 'Move a camp beyond its boundaries at the right time to spawn additional creeps.';

        // The foreign key requires us to create the user record as well
        model(UserModel::class)->insert($entity);

        $entity->addPermission('camps.stack');
    }

    /**
     * Shield does not suport names so the result should always be null.
     */
    public function testGetName()
    {
        $this->data['name'] = 'Desmond Tutu';
        $entity             = new $this->class($this->data);

        $this->assertNull($entity->name);
    }

    /**
     * Because hasPermission() (includes groups) collides with
     * Shield's native hasPermission() (ignores groups) this
     * library's extension adds the "direct" version to check.
     *
     * Note: This test should differentiate Group permissions to be accurate.
     */
    public function testHasDirectPermission()
    {
        /** @var ShieldEntity $entity */
        $entity = $this->entity;

        $this->setUpPermissions($entity);

        $this->assertFalse($entity->hasDirectPermission('creeps.lastHit'));
        $this->assertTrue($entity->hasDirectPermission('camps.stack'));
    }
}
