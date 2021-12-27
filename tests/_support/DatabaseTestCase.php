<?php

namespace Tests\Support;

use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
abstract class DatabaseTestCase extends ProjectTestCase
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
}
