<?php

namespace Tatter\Users\Entities;

use Sparks\Shield\Entities\User;
use Tatter\Users\Interfaces\HasGroup;
use Tatter\Users\Interfaces\HasPermission;

/**
 * Shield User Entity
 */
class ShieldEntity extends User implements HasGroup, HasPermission
{
    /**
     * Returns the name of the column used to
     * uniquely identify this user, typically 'id'.
     */
    public function getIdentifier(): string
    {
        return 'id';
    }

    /**
     * Returns the value for the identifier,
     * or `null` for "uncreated" users.
     *
     * @return int|string|null
     */
    public function getId()
    {
        return $this->attributes['id'] ?? null;
    }

    /**
     * Returns the email address.
     */
    public function getEmail(): ?string
    {
        return parent::getEmail();
    }

    /**
     * Returns the username.
     */
    public function getUsername(): ?string
    {
        return $this->attributes['username'] ?? null;
    }

    /**
     * Returns the name for this user.
     * If names are stored as parts "first",
     * "middle", "last" they should be
     * concatenated with spaces.
     */
    public function getName(): ?string
    {
        return null;
    }

    /**
     * Returns whether this user is eligible
     * for authentication.
     */
    public function isActive(): bool
    {
        return $this->attributes['active'] ?? false;
    }

    /**
     * Returns whether this user is a
     * member of the given group.
     *
     * @param string $group The group name
     */
    public function hasGroup(string $group): bool
    {
        return $this->inGroup($group);
    }

    /**
     * Returns whether this user has
     * a certain permission.
     *
     * WARNING: this supercedes the native
     * "hasPermission()" (which only checks
     * for direct permission) to check for
     * group permissions as well.
     *
     * @see self::hasDirectPermission()
     *
     * @param string $permission The permission name
     */
    public function hasPermission(string $permission): bool
    {
        return $this->can($permission);
    }

    /**
     * Checks to see if the user has the permission set
     * directly on themselves. This disregards any groups
     * they are part of.
     *
     * @see self::hasPermission()
     *
     * @param string $permission The permission name
     */
    public function hasDirectPermission(string $permission): bool
    {
        return parent::hasPermission($permission);
    }
}
