<?php

class AnonymousModule extends CustomModule
{
	public function __construct()
	{
		parent::__construct();

		if (User::isAuthenticated())
		{
			Browser::goHome();
		}
	}
}

?>
