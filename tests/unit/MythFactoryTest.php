<?php

use Myth\Auth\Test\Fakers\UserFaker;
use Tatter\Users\Factories\MythFactory;
use Tests\Support\FactoryTestCase;

class MythFactoryTest extends FactoryTestCase
{
	protected $namespace = 'Myth\Auth';
	protected $class     = MythFactory::class;
	protected $faker     = UserFaker::class;
}
