<?php namespace Tatter\Users\Interfaces;

use Tatter\Users\UserEntity;

/**
 * Has Group Interface
 *
 * User extension for entities that
 * can verify group membership.
 */
interface HasGroup extends UserEntity
{
	/**
	 * Returns whether this user is a
	 * member of the given group.
	 */
	public function hasGroup(string $group): bool;
}
