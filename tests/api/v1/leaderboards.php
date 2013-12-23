<?php

require_once '/usr/share/pickles-latest/classes/Object.php';
require_once '/usr/share/pickles-latest/classes/Module.php';
require_once '/usr/share/pickles-latest/classes/Config.php';
require_once '/usr/share/pickles-latest/pickles.php';
require_once './classes/CustomModule.php';
require_once './classes/APIv1.php';
require_once './modules/api/v1/leaderboards.php';

class api_v1_leaderboards_test extends PHPUnit_Framework_TestCase
{
	public function setupUp()
	{

	}

	public function tearDown()
	{

	}

	public function testNoKey()
	{
		$module = new api_v1_leaderboards();
		$return = $module->__default();

		var_dump($return);
	}
}

?>
