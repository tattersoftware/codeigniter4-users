<?php

use CodeIgniter\Config\Factories;
use Config\Services;
use Tatter\Users\UserProvider;
use Tests\Support\Mock\MockFactory;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class ServiceTest extends TestCase
{
    public function testUsesFactoriesModel()
    {
        Factories::injectMock('models', 'UserModel', new MockFactory());

        $result = Services::users(false);

        $this->assertInstanceOf(MockFactory::class, $result);
    }

    public function testUsesProvider()
    {
        $expected = 'Tatter\Users\Factories\MythFactory';

        $result = Services::users(false);

        $this->assertInstanceOf($expected, $result);
    }

    public function testUnavailableThrows()
    {
        UserProvider::setFactories([]);

        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Could not detect any UserFactory implementations.');

        Services::users(false);
    }

    public function testUsesShared()
    {
        $expected = 'Tatter\Users\Factories\MythFactory';

        Services::users(true);
        UserProvider::setFactories([]);

        $result = Services::users(true);

        $this->assertInstanceOf($expected, $result);
    }
}
