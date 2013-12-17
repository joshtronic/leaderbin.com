<?php

class AnonymousModule extends CustomModule
{
	public function __construct()
	{
		parent::__construct();

		if ($this->uid)
		{
			Browser::goHome();
		}
	}
}

?>
