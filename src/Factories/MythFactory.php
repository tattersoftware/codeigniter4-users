<?php namespace Tatter\Users\Factories;

use Myth\Auth\Models\UserModel;
use Tatter\Users\Entities\MythEntity;
use Tatter\Users\UserEntity;
use Tatter\Users\UserFactory;

/**
 * Myth User Factory
 */
class MythFactory extends UserModel implements UserFactory
{
	/**
	 * The format that the results should be returned as.
	 *
	 * @var string
	 */
    protected $returnType = MythEntity::class;

	/**
	 * Locates a user by its primary identifier.
	 *
	 * @param string|int $id
	 *
	 * @return UserEntity|null
	 */
	public function findById($id): ?MythEntity
	{
		return $this->find($id);
	}

	/**
	 * Locates a user by its email.
	 *
	 * @param string $email
	 *
	 * @return UserEntity|null
	 */
	public function findByEmail(string $email): ?MythEntity
	{
		return $this->where('email', $email)->first();
	}

	/**
	 * Locates a user by its username.
	 *
	 * @param string $username
	 *
	 * @return UserEntity|null
	 */
	public function findByUsername(string $username): ?MythEntity
	{
		return $this->where('username', $username)->first();
	}
}
