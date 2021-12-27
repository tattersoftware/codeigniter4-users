<?php

namespace Tatter\Users\Entities;

use Fluent\Auth\Entities\User;
use Tatter\Users\UserEntity;

/**
 * Fluent User Entity
 */
class FluentEntity extends User implements UserEntity
{
	/**
	 * Returns the name of the column used to
	 * uniquely identify this user, typically 'id'.
	 */
	public function getIdentifier(): string
	{
		return $this->getAuthIdColumn();
	}

	/**
	 * Returns the value for the identifier,
	 * or `null` for "uncreated" users.
	 *
	 * @return int|string|null
	 */
	public function getId()
	{
		return $this->getAuthId();
	}

	/**
	 * Returns the email address.
	 */
	public function getEmail(): ?string
	{
		return $this->getAuthEmail();
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
		return empty($this->attributes['deleted_at']);
	}
}
