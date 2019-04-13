<?php namespace Tatter\Users\Config;

use CodeIgniter\Config\BaseService;
use CodeIgniter\Database\ConnectionInterface;

class Services extends BaseService
{
    public static function permits(BaseConfig $config = null, ConnectionInterface $db = null, bool $getShared = true)
    {
		if ($getShared):
			return static::getSharedInstance('users', $db, $config);
		endif;

		// prioritizes user config in app/Config if found
		if (empty($config)):
			if (class_exists('\Config\Permits')):
				$config = new \Config\Permits();
			else:
				$config = new \Tatter\Users\Config\Users();
			endif;
		endif;

		return new \Tatter\Users\Users($config, $db);
	}
}
