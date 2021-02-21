<?php namespace Tatter\Users\Factories;

use Sparks\Shield\Models\UserModel;
use Tatter\Users\Entities\ShieldEntity;
use Tatter\Users\UserEntity;
use Tatter\Users\UserFactory;

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
	 * @return ShieldEntity|null
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
	 * @return ShieldEntity|null
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
	 * @return ShieldEntity|null
	 */
	public function findByUsername(string $username): ?ShieldEntity
	{
		return $this->where('username', $username)->first();
	}
}
