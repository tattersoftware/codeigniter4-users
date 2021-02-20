<?php namespace Tatter\Interfaces\User\Factories;

use Sparks\Shield\Models\UserModel;
use Tatter\Interfaces\User\Entities\ShieldEntity;
use Tatter\Interfaces\User\ShieldEntity;
use Tatter\Interfaces\User\UserFactory;

/**
 * Myth User Factory
 */
class ShieldFactory extends UserModel implements UserFactory
{

	/**
	 * The format that the results should be returned as.
	 *
	 * @var string
	 */
    protected $returnType = ShieldEntity::class;

	/**
	 * Locates a user by its primary identifier.
	 *
	 * @param string|int $id
	 *
	 * @return UserEntity|null
	 */
	public function findById($id): ?ShieldEntity
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
	public function findByEmail(string $email): ?ShieldEntity
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
	public function findByUsername(string $username): ?ShieldEntity
	{
		return $this->where('username', $username)->first();
	}
}
