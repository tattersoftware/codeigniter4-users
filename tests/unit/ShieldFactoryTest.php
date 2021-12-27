<?php

use Sparks\Shield\Models\UserModel;
use Tatter\Users\Factories\ShieldFactory;
use Tests\Support\FactoryTestCase;

/**
 * @internal
 */
final class ShieldFactoryTest extends FactoryTestCase
{
    protected $namespace = 'Sparks\Shield';
    protected $class     = ShieldFactory::class;
    protected $faker     = UserModel::class;
}
