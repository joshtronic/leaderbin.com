<?php

class UserModule extends CustomModule
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->uid)
		{
			Browser::redirect('/login');
		}
	}
}

?>
