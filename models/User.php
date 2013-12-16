<?php

class User extends RedisModel
{
	protected $prefix = 'user';

	public function generateToken()
	{
		return sha1(mt_rand() . microtime());
	}

	public function getAuthenticated($fields)
	{
		if (!is_array($fields))
		{
			$fields = array($fields);
		}

		if ($cookie = self::getCookie())
		{
			if ($fields == array('uid'))
			{
				return $cookie['uid'];
			}
		}

		return false;
	}

	public static function getCookie()
	{
		if (isset($_COOKIE['__auth']))
		{
			return array_combine(array('uid', 'token'), explode('|', base64_decode($_COOKIE['__auth'])));
		}

		return false;
	}

	public static function isAuthenticated()
	{
		if ($cookie = self::getCookie())
		{
			$user       = new self();
			$auth_token = $user->getAuth($cookie['uid']);

			return $auth_token === $cookie['token'];
		}
	}
}

?>
