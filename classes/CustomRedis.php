<?php

class CustomRedis extends Object
{
	protected $redis = false;

	public function __call($name, $arguments)
	{
		if (!$this->redis)
		{
			$datasource = $this->config->datasources['redis'];

			try
			{
				$this->redis = new Redis();
				$this->redis->connect($datasource['hostname'], $datasource['port']);
				$this->redis->setOption(Redis::OPT_PREFIX, $datasource['namespace'] . ':');
				$this->redis->select($datasource['database']);
			}
			catch (RedisException $e)
			{
				exit('There was error connecting to Redis :(');
			}
		}

		return call_user_func_array(array($this->redis, $name), $arguments);
	}
}

?>
