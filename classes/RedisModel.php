<?php

class RedisModel extends Object
{
	protected $redis  = false;
	protected $prefix = false;

	public function __construct()
	{
		parent::__construct();

		$this->redis = new CustomRedis();
	}

	public function key()
	{
		$parts = func_get_args();

		if ($this->prefix)
		{
			array_unshift($parts, $this->prefix);
		}

		return strtolower(implode(':', $parts));
	}

	public function nextUID()
	{
		return $this->redis->incr($this->key('uid'));
	}

	public function getUID($variable, $value)
	{
		return $this->redis->get($this->key($variable, $value, 'uid'));
	}

	public function __call($name, $arguments)
	{
		$name = strtolower($name);

		if ($name == 'set')
		{
			// Grabs our variables
			$uid       = $arguments[0];
			$variables = $arguments[1];
			$arguments = array();

			// Assembles our new arguments
			foreach ($variables as $key => $value)
			{
				$arguments[$this->key($uid, $key)] = $value;
			}

			// Sets us up for MSET or just SET
			if (count($arguments) > 1)
			{
				$name      = 'mset';
				$arguments = array($arguments);
			}
			else
			{
				$arguments = array(key($arguments), current($arguments));
			}
		}
		else
		{
			$base = substr($name, 0, 3);

			if (in_array($base, array('set', 'get')))
			{
				$key  = $this->key($arguments[0], substr($name, 3));
				$name = $base;
			}

			switch ($base)
			{
				case 'set':
					$arguments = array($key, $arguments[1]);
					break;

				case 'get':
					$arguments = array($key);
					break;
			}
		}

		return call_user_func_array(array($this->redis, $name), $arguments);
	}
}

?>
