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
		try
		{
			$user = new User();

			// Checks if the email or username is already in use
			foreach (array('email', 'username') as $field)
			{
				if ($user->getMapping($field, $_POST[$field]))
				{
					return array('error' => 'The ' . $field . ' is already in use.');
				}
			}

			// Grabs the next UID
			$uid = $user->nextUID();

			// Generates the auth token
			$auth_token = $user->generateToken();

			// Writes the user data
			$user->set($uid, array(
				'username' => $_POST['username'],
				'email'    => $_POST['email'],
				'password' => crypt($_POST['password'], '$2y$11$' . String::random(22) . '$'),
				'auth'     => $auth_token,
			));

			// Sets the UID mappings
			$user->setMapping('username', $_POST['username'], $uid);
			$user->setMapping('email',    $_POST['email'],    $uid);

			// Sets a cookie with the UID and auth token
			setcookie('__auth', base64_encode($uid . '|' . $auth_token), time() + Time::YEAR, '/');

			return array('status' => 'success', 'url' => '/');
		}
		catch (RedisException $e)
		{
			return array('error' => $e->getMessage());
		}
	}
}

?>
