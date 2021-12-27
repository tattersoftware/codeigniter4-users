<?php

namespace Tatter\Users\Factories;

use Fluent\Auth\Models\UserModel;
use Tatter\Users\Entities\FluentEntity;
use Tatter\Users\UserEntity;
use Tatter\Users\UserFactory;

/**
 * Fluent User Factory
 */
class FluentFactory extends UserModel implements UserFactory
{
    /**
     * The format that the results should be returned as.
     *
     * @var string
     */
    protected $returnType = FluentEntity::class;

    /**
     * Locates a user by its primary identifier.
     *
     * @param int|string $id
     *
     * @return FluentEntity|null
     */
    public function findById($id): ?UserEntity
    {
        /** @var FluentEntity|null $result */
        $result = parent::findById($id);

        return $result;
    }

    /**
     * Locates a user by its email.
     *
     * @return FluentEntity|null
     */
    public function findByEmail(string $email): ?UserEntity
    {
        /** @var FluentEntity|null $result */
        $result = $this->findByCredentials(['email' => $email]);

        return $result;
    }

    /**
     * Locates a user by its username.
     *
     * @return FluentEntity|null
     */
    public function findByUsername(string $username): ?UserEntity
    {
        /** @var FluentEntity|null $result */
        $result = $this->findByCredentials(['username' => $username]);

        return $result;
    }
}
