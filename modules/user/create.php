<?php

class user_create extends AnonymousModule
{
	protected $ajax     = true;
	protected $method   = 'POST';
	protected $validate = array(
		'email' => array(
			'length:>:100'           => 'Email addresses may not be more than 100 characters.',
			'filter:email'           => 'Your email address is invalid.',
		),
		'username' => array(
			'length:<:4'             => 'Usernames may not be less than 4 characters.',
			'length:>:30'            => 'Usernames may not be more than 50 characters.',
			'regex:is:/[^a-z0-9]+/i' => 'Usernames may only contain letters and numbers.',
		),
		'password' => array(
			'length:<:8'             => 'Passwords may not be less than 8 characters.',
		),
	);

	public function __default()
	{
		// Removes any stray whitespace
		$_POST['email']    = trim($_POST['email']);
		$_POST['username'] = trim($_POST['username']);

		try
		{
			$mapping_fields = array(
				'user:email:'    . $_POST['email'],
				'user:username:' . $_POST['username'],
			);

			// Checks if the email or username is already in use
			$existing = $this->redis->mget($mapping_fields);

			if ($existing[0])
			{
				throw new Exception('The email address is already in use.');
			}
			elseif ($existing[1])
			{
				throw new Exception('The username is already in use.');
			}

			// Grabs the next UID
			$uid = $this->redis->incr('user:uid');

			// Generates the auth token
			$auth_token = sha1(microtime());

			// Writes the user data
			$this->redis->hmset('user:' . $uid, array(
				'username' => $_POST['username'],
				'email'    => $_POST['email'],
				'password' => crypt($_POST['password'], '$2y$11$' . String::random(22) . '$'),
				'auth'     => $auth_token,
			));

			// Creates an API key for the user
			$api_key = false;

			while (!$api_key)
			{
				$new_key   = sha1(microtime() . mt_rand());
				$redis_key = 'user:api:' . $new_key;

				if ($this->redis->get($redis_key) === false)
				{
					$api_key = $new_key;
					$this->redis->set($redis_key, $api_key);
				}
			}

			$mapping_fields[] = 'user:api:' . $api_key;

			// Sets the UID mappings
			$this->redis->mset(array_combine($mapping_fields, array($uid, $uid, $uid)));

			// Sets a cookie with the UID and auth token
			setcookie('__auth', base64_encode($uid . '|' . $auth_token), time() + Time::YEAR, '/');

			return array('status' => 'success', 'url' => '/leaderboards');
		}
		catch (Exception $e)
		{
			return array('error' => $e->getMessage());
		}
	}
}

?>
