<?php

namespace Tatter\Users\Factories;

use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Models\UserModel;
use Tatter\Users\Entities\ShieldEntity;
use Tatter\Users\UserFactory;

/**
 * Shield User Factory
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
     */
    public function findById($id): ?ShieldEntity
    {
        return $this->find($id);
    }

    /**
     * Locates a user by its email.
     */
    public function findByEmail(string $email): ?ShieldEntity
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
     */
    public function findByUsername(string $username): ?ShieldEntity
    {
        return $this->where('username', $username)->first();
    }
}
