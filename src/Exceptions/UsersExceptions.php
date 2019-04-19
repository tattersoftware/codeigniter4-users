<?php namespace Tatter\Users\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;
use CodeIgniter\Exceptions\FrameworkException;

class UsersException extends FrameworkException implements ExceptionInterface
{
	public static function forMissingDatabaseTable(string $table)
	{
		return new static(lang('Users.missingDatabaseTable');
	}
	
	public static function forInvalidDepth($depth)
	{
		return new static(lang('Users.invalidDepth', $depth));
	}
	
	public static function forUnsupportedMethod($methodName)
	{
		return new static(lang('Users.unsupportedMethod', $methodName));
	}
	
	public static function forMissingLoginField()
	{
		return new static(lang('Users.missingLoginField'));
	}
	
	public static function forGeneralFailure()
	{
		return new static(lang('Users.generalFailure'));
	}
}
