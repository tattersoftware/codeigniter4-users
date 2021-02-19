<?php namespace Tatter\Interfaces;

/**
 * User Interface
 *
 * Provides a common interface for
 * classes representing a user.
 */
interface User
{
	/**
	 * Returns the name of the column used to
	 * uniquely identify this user, typically 'id'.
	 *
	 * @return string
	 */
	public function getIdentifier(): string;

	/**
	 * Returns the value for the identifier,
	 * or `null` for "uncreated" users.
	 *
	 * @return string|int|null
	 */
	public function getId();

	/**
	 * Returns the email address.
	 *
	 * @return string|null
	 */
	public function getEmail(): ?string;

	/**
	 * Returns the username.
	 *
	 * @return string|null
	 */
	public function getUsername(): ?string;

	/**
	 * Returns the name for this user.
	 * If names are stored as parts "first",
	 * "middle", "last" they should be
	 * concatenated with spaces.
	 *
	 * @return string|null
	 */
	public function getName(): ?string;

	/**
	 * Returns the user's initials. These
	 * should be letters only, no spaces
	 * or punctuation.
	 *
	 * @return string|null
	 */
	public function getInitials(): ?string;

	/**
	 * Returns whether this user is eligible
	 * for authentication.
	 *
	 * @return bool
	 */
	public function isActive(): bool;
}
