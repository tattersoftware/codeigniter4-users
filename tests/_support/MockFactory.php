<?php

namespace Tests\Support;

use Tatter\Users\UserEntity;
use Tatter\Users\UserFactory;

class MockFactory implements UserFactory
{
	public function findById($id): ?UserEntity
	{
		return new MockEntity();
	}

	public function findByEmail(string $email): ?UserEntity
	{
		return new MockEntity();
	}

	public function findByUsername(string $username): ?UserEntity
	{
		return new MockEntity();
	}
}
