<?php

use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Config\Auth;
use CodeIgniter\Shield\Models\UserModel;
use Config\Services;
use Tatter\Users\Factories\ShieldFactory;
use Tatter\Users\Test\FactoryTestCase;

/**
 * @internal
 */
final class ShieldFactoryTest extends FactoryTestCase
{
    protected $namespace = 'CodeIgniter\Shield';
    protected $class     = ShieldFactory::class;
    protected $faker     = UserModel::class;

    // Shield uses identities not included with the faker so we have to create an email ourselves
    public function testEmail()
    {
        Services::injectMock('passwords', new Passwords(new Auth()));

        $this->user->createEmailIdentity(
            [
                'email'    => 'jim@example.com',
                'password' => 'secret', ],
        );

        parent::testEmail();
    }
}
