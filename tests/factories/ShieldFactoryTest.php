<?php

use Sparks\Shield\Models\UserModel;
use Tatter\Users\Factories\ShieldFactory;
use Tatter\Users\Test\FactoryTestCase;

/**
 * @internal
 */
final class ShieldFactoryTest extends FactoryTestCase
{
    protected $namespace = 'Sparks\Shield';
    protected $class     = ShieldFactory::class;
    protected $faker     = UserModel::class;

    // Shield uses identities not included with the faker so we have to create an email ourselves
    public function testEmail()
    {
        $this->user->createEmailIdentity(
            [
                'email'    => 'jim@example.com',
                'password' => 'secret', ],
        );

        parent::testEmail();
    }
}
