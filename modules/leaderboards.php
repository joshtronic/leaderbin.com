<?php

class leaderboards extends UserModule
{
	public function __default()
	{
		// Grabs the user's leaderboards
		$leaders = '';

		return array('leaderboards' => $leaderboards);
	}
}

?>
