<?php

namespace Tatter\Users\Config;

use CodeIgniter\Config\Factories;
use Config\Services as BaseServices;
use RuntimeException;
use Tatter\Users\UserFactory;
use Tatter\Users\UserProvider;

class Services extends BaseServices
{
    /**
     * Locates a valid User Factory.
     *
     * @throws RuntimeException If no factory is available
     */
    public static function users(bool $getShared = true): UserFactory
    {
        if ($getShared) {
            return static::getSharedInstance('users');
        }

        // First check for a valid User Model
        /** @var UserFactory|null $model */
        $model = Factories::models('UserModel', ['instanceOf' => UserFactory::class]);
        if (null !== $model) {
            return $model;
        }

        // Use the provider to check for known factories
        foreach (UserProvider::getFactories() as $check => $factory) {
            if (class_exists($check)) {
                return new $factory();
            }
        }

        throw new RuntimeException('Could not detect any UserFactory implementations.');
    }
}
