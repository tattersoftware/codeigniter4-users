<?php

use CodeIgniter\Test\DatabaseTestTrait;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Authorization\PermissionModel;
use Myth\Auth\Models\UserModel;
use Tatter\Users\Entities\MythEntity;
use Tatter\Users\Interfaces\HasGroup;
use Tatter\Users\Interfaces\HasPermission;
use Tatter\Users\Test\EntityTestCase;

/**
 * @internal
 */
final class MythEntityTest extends EntityTestCase
{
    // Groups require an external table for Myth so we need the database
    use DatabaseTestTrait;

    protected $namespace = 'Myth\Auth';
    protected $class     = MythEntity::class;

    /**
     * Creates the scenario for entities that implement HasGroup
     * to verify the following checks:
     *  - $this->entity->hasGroup('dire') === false
     *  - $this->entity->hasGroup('radiant') === true
     */
    protected function setUpGroups(HasGroup $entity): void
    {
        // The foreign key requires us to create the user record as well
        $entity->password = bin2hex(random_bytes(16)); // @phpstan-ignore-line
        model(UserModel::class)->insert($entity);

        // Create the group and add the User to it
        $group = fake(GroupModel::class, [
            'name' => 'radiant',
        ]);

        /** @var GroupModel $groups */
        $groups = model(GroupModel::class);
        $groups->addUserToGroup($entity->getId(), $group->id); // @phpstan-ignore-line
    }

    /**
     * Creates the scenario for entities that implement HasPermission
     * to verify the following checks:
     *  - $this->entity->hasPermission('creeps.lastHit') === false
     *  - $this->entity->hasPermission('camps.stack') === true
     *
     * @param MythEntity $entity
     */
    protected function setUpPermissions(HasPermission $entity): void
    {
        // The foreign key requires us to create the user record as well
        $entity->password = bin2hex(random_bytes(16));
        model(UserModel::class)->insert($entity);

        // Create the group and add the User to it
        $permission = fake(PermissionModel::class, [
            'name' => 'camps.stack',
        ]);

        /** @var PermissionModel $permissions */
        $permissions = model(PermissionModel::class);
        $permissions->addPermissionToUser($entity->id, $permission['id']);
    }

    /**
     * Myth does not suport names so the result should always be null.
     */
    public function testGetName()
    {
        $this->data['name'] = 'Desmond Tutu';
        $entity             = new $this->class($this->data);

        $this->assertNull($entity->name);
    }
}
