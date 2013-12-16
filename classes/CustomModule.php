<?php

class CustomModule extends Module
{
	protected $redis = false;

	public function __construct()
	{
		parent::__construct();

		$this->redis = new CustomRedis();
	}
}

?>
