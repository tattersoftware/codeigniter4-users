<?php

namespace Tatter\Users;

/**
 * User Interface
 *
 * Provides a common interface for
 * classes representing a user.
 */
interface UserEntity
{
    /**
     * Returns the name of the column used to
     * uniquely identify this user, typically 'id'.
     */
    public function getIdentifier(): string;

    /**
     * Returns the value for the identifier,
     * or `null` for "uncreated" users.
     *
     * @return int|string|null
     */
    public function getId();

    /**
     * Returns the email address.
     */
    public function getEmail(): ?string;

    /**
     * Returns the username.
     */
    public function getUsername(): ?string;

    /**
     * Returns the name for this user.
     * If names are stored as parts "first",
     * "middle", "last" they should be
     * concatenated with spaces.
     */
    public function getName(): ?string;

    /**
     * Returns whether this user is eligible
     * for authentication.
     */
    public function isActive(): bool;
}
