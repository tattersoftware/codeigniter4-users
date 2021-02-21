<?php namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use Tatter\Users\UserProvider;

class ProjectTestCase extends CIUnitTestCase
{
	/**
	 * @var array<string,string>|null
	 */
	private $factoriesBackup;

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

		UserProvider::setFactories($this->factoriesBackup);
		$this->factoriesBackup = null;
	}
}
