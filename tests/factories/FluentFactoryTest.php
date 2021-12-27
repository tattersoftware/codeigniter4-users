<?php

use Fluent\Auth\Models\UserModel;
use Tatter\Users\Factories\FluentFactory;
use Tatter\Users\Test\FactoryTestCase;

/**
 * @internal
 */
final class FluentFactoryTest extends FactoryTestCase
{
    protected $namespace = 'Fluent\Auth';
    protected $class     = FluentFactory::class;
    protected $faker     = UserModel::class;
}
