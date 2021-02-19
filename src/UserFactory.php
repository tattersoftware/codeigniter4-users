<?php namespace Tatter\Interfaces;

/**
 * User Factory Interface
 *
 * Provides a common interface for
 * classes that create Users.
 * Typically for Models.
 */
interface UserFactory
{
	/**
	 * Locates a User by its primary identifier.
	 *
	 * @param string|int $id
	 *
	 * @return User|null
	 */
	public function findById($id): ?User;

	/**
	 * Locates a User by its email.
	 *
	 * @param string $email
	 *
	 * @return User|null
	 */
	public function findByEmail(string $email): ?User;

	/**
	 * Locates a User by its username.
	 *
	 * @param string $username
	 *
	 * @return User|null
	 */
	public function findByUsername(string $username): ?User;
}
