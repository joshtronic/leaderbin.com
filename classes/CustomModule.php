<?php

class CustomModule extends Module
{
	protected $redis = false;
	protected $uid   = false;

	public function __construct()
	{
		parent::__construct();

		$this->redis = new CustomRedis();

		$class = get_class($this);

		if ($class == 'api' || substr($class, 0, 3) != 'api')
		{
			if (isset($_COOKIE['__auth']))
			{
				list($uid, $auth_token) = explode('|', base64_decode($_COOKIE['__auth']));

				if ($this->redis->hget('user:' . $uid, 'auth') === $auth_token)
				{
					$this->uid           = $uid;
					$this->return['uid'] = $uid;
				}
			}
		}
	}
}

?>
