<?php

class CustomModule extends Module
{
	protected $redis = false;

	public function __construct()
	{
		parent::__construct();

		$this->redis = new CustomRedis();

		/*
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

		}
		*/
	}
}

?>
