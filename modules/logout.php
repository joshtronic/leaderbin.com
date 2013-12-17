<?php

class logout extends UserModule
{
	public function __default()
	{
		$this->redis->hset('user:' . $this->uid, sha1(microtime()));

		setcookie('__auth', '', time() - Time::YEAR, '/');

		Browser::goHome();
	}
}

?>
