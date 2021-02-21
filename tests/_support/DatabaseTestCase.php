<?php namespace Tests\Support;

use CodeIgniter\Test\CIDatabaseTestCase;

class DatabaseTestCase extends CIDatabaseTestCase
{
	use TestCaseTrait;

	/**
	 * The namespace(s) to help us find the migration classes.
	 * Empty is equivalent to running `spark migrate -all`.
	 * Note that running "all" runs migrations in date order,
	 * but specifying namespaces runs them in namespace order (then date)
	 *
	 * @var string|array|null
	 */
	protected $namespace = null;
}
