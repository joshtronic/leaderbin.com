<?php

class leaderboard_create extends leaderboard_new
{
	protected $ajax     = true;
	protected $method   = 'POST';
	protected $validate = array(
		'name' => array(
			'length:>:100' => 'Leaderboard name may not be more than 100 characters.',
		),
	);

	public function __default()
	{
		// Grabs the next UID
		$uid_key = 'leaderboard:uid';

		if ($this->redis->get($uid_key) === false)
		{
			$uid = 1000000;
			$this->redis->set($uid_key, $uid);
		}
		else
		{
			$uid = $this->redis->incr($uid_key);
		}

		$timestamp = time();
		$record    = array(
			'name'       => $_POST['name'],
			'uid'        => $this->uid,
			'created_at' => $timestamp,
		);

		// Creates the rest of the data for the leaderboard
		$this->redis->multi()
			->hmset('leaderboard:' . $uid, $record)
			->zadd('user:' . $this->uid . ':leaderboards:updated', $timestamp, $uid)
			->zadd('leaderboards:updated', $timestamp, $uid)
			->exec();

		return array('status' => 'success', 'url' => '/leaderboards');
	}
}

?>
