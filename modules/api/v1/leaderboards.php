<?php

class api_v1_leaderboards extends APIv1
{
	public $request_methods = 'GET';

	public function __default()
	{
		if (!isset($this->return['error']))
		{
			$leaderboards = new leaderboards();

			return $leaderboards->__default();
		}
	}
}

?>
