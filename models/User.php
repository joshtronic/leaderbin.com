<?php

class User extends RedisModel
{
	protected $prefix = 'user';

	public static function isAuthenticated()
	{
		if (isset($_COOKIE['__auth']))
		{
			list($uid, $auth_token) = explode('|', base64_decode($_COOKIE['__auth']));

			$user       = new self();
			$user_token = $user->getAuth($uid);

			return $user_token === $auth_token;
		}
	}
}

?>
