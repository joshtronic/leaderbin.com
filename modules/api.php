<?php

class api extends CustomModule
{
	public function __default()
	{
		// Grabs the user's API key
		$api_key = false;

		if ($this->uid)
		{
			$api_key = $this->redis->hget('user:' . $this->uid, 'api');
		}

		return array('api_key' => $api_key);
	}
}

?>
