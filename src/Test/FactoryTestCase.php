<?php

namespace Tatter\Users\Test;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tatter\Users\UserEntity;
use Tatter\Users\UserFactory;

abstract class FactoryTestCase extends CIUnitTestCase
{
    use DatabaseTestTrait;

    /**
     * The namespace(s) to help us find the migration classes.
     * Empty is equivalent to running `spark migrate -all`.
     * Note that running "all" runs migrations in date order,
     * but specifying namespaces runs them in namespace order (then date)
     *
     * @var array|string|null
     */
    protected $namespace;

    /**
     * The factory class to test.
     *
     * @var string
     */
    protected $class;

    /**
     * The factory instance.
     *
     * @var UserFactory
     */
    protected $factory;

    /**
     * The model class to use for creating a faked database entity.
     *
     * @var string
     */
    protected $faker;

    /**
     * The test user created by the faker.
     *
     * @var object
     */
    protected $user;

    /**
     * Sets up the test instances.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new $this->class();
        $this->createEntity();
    }

    /**
     * Creates the test entity.
     */
    protected function createEntity(): void
    {
        $this->user = fake($this->faker);
    }

    public function testId()
    {
        $result = $this->factory->findById($this->user->id);

        $this->assertInstanceof(UserEntity::class, $result);
        $this->assertSame($this->user->id, $result->getId());
    }

    public function testIdMissing()
    {
        $result = $this->factory->findById(1234);

        $this->assertNull($result);
    }

    public function testEmail()
    {
        $result = $this->factory->findByEmail($this->user->email);

        $this->assertInstanceof(UserEntity::class, $result);
        $this->assertSame($this->user->id, $result->getId());
    }

    public function testEmailMissing()
    {
        $result = $this->factory->findByEmail('banana@barbados.net');

        $this->assertNull($result);
    }

    public function testUsername()
    {
        $result = $this->factory->findByUsername($this->user->username);

        $this->assertInstanceof(UserEntity::class, $result);
        $this->assertSame($this->user->id, $result->getId());
    }

    public function testUsernameMissing()
    {
        $result = $this->factory->findByUsername('elaborate.ploy');

        $this->assertNull($result);
    }
}
