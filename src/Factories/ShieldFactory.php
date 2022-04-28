<?php

namespace Tatter\Users\Factories;

use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Models\UserModel;
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
     * @param int|string $id
     *
     * @return ShieldEntity|null
     */
    public function findById($id): ?UserEntity
    {
        return $this->find($id);
    }

    /**
     * Locates a user by its email.
     *
     * @return ShieldEntity|null
     */
    public function findByEmail(string $email): ?UserEntity
    {
        $identity = model(UserIdentityModel::class)->where([
            'type'   => 'email_password',
            'secret' => $email,
        ])->first();

        if ($identity === null) {
            return null;
        }

        return $this->findById($identity->user_id);
    }

    /**
     * Locates a user by its username.
     *
     * @return ShieldEntity|null
     */
    public function findByUsername(string $username): ?UserEntity
    {
        return $this->where('username', $username)->first();
    }
}
