<?php namespace Tatter\Users\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;
use CodeIgniter\Exceptions\FrameworkException;

class UsersException extends FrameworkException implements ExceptionInterface
{
	public static function forMissingDatabaseTable(string $table)
	{
		return new static("Table `{$table}` missing for user authentication");
	}
}
