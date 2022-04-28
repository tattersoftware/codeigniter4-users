<?php

namespace Tatter\Users;

use CodeIgniter\Model;
use CodeIgniter\Shield\Models\UserModel as ShieldModel;
use Fluent\Auth\Models\UserModel as FluentModel;
use Myth\Auth\Models\UserModel as MythModel;
use Tatter\Users\Factories\FluentFactory;
use Tatter\Users\Factories\MythFactory;
use Tatter\Users\Factories\ShieldFactory;

/**
 * User Provider Class
 *
 * Provides automatic discovery
 * of known User Factories.
 */
class UserProvider
{
    /**
     * Known factories. Keys are the
     * class to check availability.
     *
     * @var array<class-string<Model>,class-string<UserFactory>>
     */
    protected static $factories = [
        MythModel::class   => MythFactory::class,
        ShieldModel::class => ShieldFactory::class,
        FluentModel::class => FluentFactory::class,
    ];

    /**
     * Returns the array of known factories
     *
     * @return array<string,string>
     */
    public static function getFactories(): array
    {
        return static::$factories;
    }

    /**
     * Sets the array of known factories.
     *
     * @param array<string,string> $factories
     */
    public static function setFactories(array $factories): void
    {
        static::$factories = $factories;
    }

    /**
     * Prepends a new factory, giving it priority.
     */
    public static function addFactory(string $check, string $factory): void
    {
        static::$factories = array_merge([$check => $factory], static::$factories);
    }
}
