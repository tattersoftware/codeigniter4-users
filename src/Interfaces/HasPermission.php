<?php namespace Tatter\Users\Interfaces;

use Tatter\Users\UserEntity;

/**
 * Has Permission Interface
 *
 * User extension for entities that
 * can check for a designated permission.
 */
interface HasPermission extends UserEntity
{
	/**
	 * Returns whether this user has the given permission.
	 * Must be comprehensive and cascading (i.e. if auth
	 * support global or group permissions those should
	 * both be checked in addition to explicit user rights).
	 */
	public function hasPermission(string $permission): bool;
}
