<?php

use Tatter\Users\UserProvider;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class ProviderTest extends TestCase
{
    public function testGetFactories()
    {
        $expected = [
            'Myth\Auth\Models\UserModel'          => 'Tatter\Users\Factories\MythFactory',
            'CodeIgniter\Shield\Models\UserModel' => 'Tatter\Users\Factories\ShieldFactory',
            'Fluent\Auth\Models\UserModel'        => 'Tatter\Users\Factories\FluentFactory',
        ];

        $this->assertSame($expected, UserProvider::getFactories());
    }

    public function testSetFactories()
    {
        $expected = ['foo' => 'bar'];

        UserProvider::setFactories($expected);

        $this->assertSame($expected, UserProvider::getFactories());
    }

    public function testAddFactory()
    {
        $expected = [
            'foo'                                 => 'bar',
            'Myth\Auth\Models\UserModel'          => 'Tatter\Users\Factories\MythFactory',
            'CodeIgniter\Shield\Models\UserModel' => 'Tatter\Users\Factories\ShieldFactory',
            'Fluent\Auth\Models\UserModel'        => 'Tatter\Users\Factories\FluentFactory',
        ];

        UserProvider::addFactory('foo', 'bar');

        $this->assertSame($expected, UserProvider::getFactories());
    }
}
