<?php namespace Tatter\Users\Entities;

use Sparks\Shield\Entities\User;
use Tatter\Users\UserEntity;

/**
 * Shield User Entity
 */
class ShieldEntity extends User implements UserEntity
{
	/**
	 * Returns the name of the column used to
	 * uniquely identify this user, typically 'id'.
	 *
	 * @return string
	 */
	public function getIdentifier(): string
	{
		return 'id';
	}

	/**
	 * Returns the value for the identifier,
	 * or `null` for "uncreated" users.
	 *
	 * @return string|int|null
	 */
	public function getId()
	{
		return $this->attributes['id'] ?? null;
	}

	/**
	 * Returns the email address.
	 *
	 * @return string|null
	 */
	public function getEmail(): ?string
	{
		return parent::getEmail();
	}

	/**
	 * Returns the username.
	 *
	 * @return string|null
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
	 *
	 * @return string|null
	 */
	public function getName(): ?string
	{
		return null;
	}

	/**
	 * Returns whether this user is eligible
	 * for authentication.
	 *
	 * @return bool
	 */
	public function isActive(): bool
	{
		return $this->attributes['active'] ?? false;
	}
}
