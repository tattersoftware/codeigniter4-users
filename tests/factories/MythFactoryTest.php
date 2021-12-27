<?php

use Myth\Auth\Test\Fakers\UserFaker;
use Tatter\Users\Factories\MythFactory;
use Tatter\Users\Test\FactoryTestCase;

/**
 * @internal
 */
final class MythFactoryTest extends FactoryTestCase
{
    protected $namespace = 'Myth\Auth';
    protected $class     = MythFactory::class;
    protected $faker     = UserFaker::class;
}
