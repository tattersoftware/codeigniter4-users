<?php

namespace Tatter\Users;

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
     * @param int|string $id
     */
    public function findById($id): ?UserEntity;

    /**
     * Locates a user by its email.
     */
    public function findByEmail(string $email): ?UserEntity;

    /**
     * Locates a user by its username.
     */
    public function findByUsername(string $username): ?UserEntity;
}
