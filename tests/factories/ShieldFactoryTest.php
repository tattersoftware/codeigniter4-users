<?php

use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Models\UserModel;
use Tatter\Users\Factories\ShieldFactory;
use Tatter\Users\Test\FactoryTestCase;

/**
 * @internal
 *
 * @group SeparateProcess
 */
final class ShieldFactoryTest extends FactoryTestCase
{
    protected $namespace = 'CodeIgniter\Shield';
    protected $class     = ShieldFactory::class;
    protected $faker     = UserModel::class;

    // Shield uses identities not included with the faker so we have to create an email ourselves
    public function testEmail()
    {
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        $identityModel->insert([
            'user_id' => $this->user->id,
            'type'    => 'email_password',
            'secret'  => 'jim@example.com',
            'secret2' => 'hased_secret',
        ]);

        parent::testEmail();
    }
}
