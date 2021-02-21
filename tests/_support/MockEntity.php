<?php namespace Tests\Support;

use Tatter\Users\UserEntity;

class MockEntity implements UserEntity
{
	public function getIdentifier(): string
	{
		return '';
	}

	public function getId()
	{
		return null;
	}

	public function getEmail(): ?string
	{
		return null;
	}

	public function getUsername(): ?string
	{
		return null;
	}

	public function getName(): ?string
	{
		return null;
	}

	public function isActive(): bool
	{
		return false;
	}
}
