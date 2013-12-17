<?php

class user_authenticate extends AnonymousModule
{
	protected $ajax     = true;
	protected $method   = 'POST';
	protected $validate = array(
		'email' => array(
			'length:>:100' => 'Invalid email address or password.',
			'filter:email' => 'Invalid email address or password.',
		),
		'password' => array(
			'length:<:8'   => 'Invalid email address or password.',
		),
	);

	public function __default()
	{
		try
		{
			$user = new User();

			// Checks if the email supplied is valid
			if ($uid = $user->getMapping('email', $_POST['email']))
			{
				// Checks if the password is valid
				$password = $user->getPassword($uid);

				if ($password == crypt($_POST['password'], $password))
				{
					$auth_token = $user->getAuth($uid);
					setcookie('__auth', base64_encode($uid . '|' . $auth_token), time() + Time::YEAR, '/');
				}
			}

			return array('status' => 'success', 'url' => '/');
		}
		catch (RedisException $e)
		{
			return array('error' => $e->getMessage());
		}

		return array('error' => 'Invalid email address or password.');
	}
}

?>
