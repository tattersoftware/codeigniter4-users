<?php namespace Tatter\Users;

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
	 * Locates a user by its primary identifier.
	 *
	 * @param string|int $id
	 *
	 * @return UserEntity|null
	 */
	public function findById($id): ?UserEntity;

	/**
	 * Locates a user by its email.
	 *
	 * @param string $email
	 *
	 * @return UserEntity|null
	 */
	public function findByEmail(string $email): ?UserEntity;

	/**
	 * Locates a user by its username.
	 *
	 * @param string $username
	 *
	 * @return UserEntity|null
	 */
	public function findByUsername(string $username): ?UserEntity;
}
