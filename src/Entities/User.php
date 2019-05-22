<?php namespace Tatter\Users\Entities;

use CodeIgniter\Entity;

class User extends Entity
{
	protected $dates = ['created_at', 'verified_at', 'updated_at'];

    public function setCreatedAt(string $dateString)
    {
        $this->created_at = new Time($dateString, 'UTC');
        return $this;
    }

    public function getCreatedAt(string $format = 'Y-m-d H:i:s')
    {
        // Convert to CodeIgniter\I18n\Time object
        $this->created_at = $this->mutateDate($this->created_at);
        $timezone = $this->timezone ?? app_timezone();
        $this->created_at->setTimezone($timezone);

        return $this->created_at->format($format);
    }
	
	// Automatically hashes the password when set.
	// https://github.com/lonnieezell/myth-auth/blob/develop/src/Entities/User.php
	// https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
	public function setPassword(string $password)
	{
		$this->password = password_hash(
			base64_encode(hash('sha512', $password, true)),
			PASSWORD_DEFAULT
		);
	}
}
