<?php

class logout extends UserModule
{
	public function __default()
	{
		$user = new User();
		$user->setAuth($user->getAuthenticated('uid'), $user->generateToken());

		setcookie('__auth', '', time() - Time::YEAR, '/');

		Browser::goHome();
	}
}

?>
