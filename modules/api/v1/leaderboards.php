<?php

class api_v1_leaderboards extends APIv1
{
	protected $request_methods = 'GET';

	public function __default()
	{
		$leaderboards = new leaderboards();

		return $leaderboards->__default();
	}
}

?>
