<?php

class leaderboards extends UserModule
{
	public function __default()
	{
		// Grabs the user's leaderboards
		$leaderboards = array();

		return array('leaderboards' => $leaderboards);
	}
}

?>
