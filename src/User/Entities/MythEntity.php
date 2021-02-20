<?php namespace Tatter\Interfaces\User\Entities;

use Myth\Auth\Entities\User;
use RuntimeException;

/**
 * Myth User Entity
 */
class MythEntity extend User
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
		return $this->attributes['email'] ?? null;
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
		throw new RuntimeException('That attribute is not supported');
	}

	/**
	 * Returns whether this user is eligible
	 * for authentication.
	 *
	 * @return bool
	 */
	public function isActive(): bool
	{
		return $this->isActivated();
	}
}
