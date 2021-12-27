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

    // Shield's faker does not include email yet so skip this test for now
    public function testEmail()
    {
        $this->markTestSkipped();
    }
}
