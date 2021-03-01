<?php namespace Tatter\Users\Interfaces;

use Tatter\Users\UserEntity;

/**
 * Has Permission Interface
 *
 * User extension for entities that
 * can test a designated permission.
 */
interface HasPermission extends UserEntity
{
	/**
	 * Returns whether this user has
	 * a certain permission.
	 *
	 * @param string $permission The permission name
	 *
	 * @return bool
	 */
	public function hasPermission(string $permission): bool;
}
