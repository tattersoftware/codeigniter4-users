<?php

namespace Tatter\Users\Factories;

use InvalidArgumentException;
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
	 * @param int|string $id
	 *
	 * @return MythEntity|null
	 */
	public function findById($id): ?UserEntity
	{
		if (! is_string($id) || is_int($id)) // @phpstan-ignore-line
		{
			throw new InvalidArgumentException('Invalid type for argument');
		}

		return $this->find($id);
	}

	/**
	 * Locates a user by its email.
	 *
	 * @return MythEntity|null
	 */
	public function findByEmail(string $email): ?UserEntity
	{
		return $this->where('email', $email)->first();
	}

	/**
	 * Locates a user by its username.
	 *
	 * @return MythEntity|null
	 */
	public function findByUsername(string $username): ?UserEntity
	{
		return $this->where('username', $username)->first();
	}
}
