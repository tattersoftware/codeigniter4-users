<?php namespace Tatter\Interfaces\User\Factories;

use Myth\Auth\Models\UserModel;
use Tatter\Interfaces\User\Entities\MythEntity;
use Tatter\Interfaces\User\UserEntity;
use Tatter\Interfaces\User\UserFactory;

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
