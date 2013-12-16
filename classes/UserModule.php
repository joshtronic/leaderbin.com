<?php

class UserModule extends CustomModule
{
	public function __construct()
	{
		parent::__construct();

		if (!User::isAuthenticated())
		{
			Browser::redirect('/login');
		}
	}
}

?>
