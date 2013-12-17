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
		// Checks if the email supplied is valid
		if ($uid = $this->redis->get('user:email:' . trim($_POST['email'])))
		{
			// Grabs the password hash and auth token
			$user = $this->redis->hmget('user:' . $uid, array('password', 'auth'));

			// Checks if the password is valid
			if ($user['password'] == crypt($_POST['password'], $user['password']))
			{
				setcookie('__auth', base64_encode($uid . '|' . $user['auth']), time() + Time::YEAR, '/');
			}

			return array('status' => 'success', 'url' => '/');
		}

		return array('error' => 'Invalid email address or password.');
	}
}

?>
