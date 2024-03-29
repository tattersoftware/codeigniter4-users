<?php

namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use Config\Services;
use Tatter\Users\UserProvider;

/**
 * @internal
 */
abstract class TestCase extends CIUnitTestCase
{
    /**
     * @var array<string,string>|null
     */
    private ?array $factoriesBackup;

    /**
     * Backs up factories so they can
     * be restore after each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->factoriesBackup = UserProvider::getFactories();
    }

    /**
     * Restores factories after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        Services::reset();
        UserProvider::setFactories($this->factoriesBackup);
        $this->factoriesBackup = null;
    }
}
