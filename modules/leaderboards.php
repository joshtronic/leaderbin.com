<?php

class leaderboards extends UserModule
{
	public function __default()
	{
		// Grabs the user's leaderboards
		$leaderboards = $this->redis->zrevrange('user:' . $this->uid . ':leaderboards:updated', 0, -1, 'WITHSCORES');
		$names        = array();

		if ($leaderboards)
		{
			$this->redis->multi();

			$leaderboard_uids = array();

			foreach ($leaderboards as $uid => $updated_at)
			{
				$leaderboard_uids[] = $uid;
				$this->redis->hget('leaderboard:' . $uid, 'name');
			}

			$names = array_combine($leaderboard_uids, $this->redis->exec());
		}

		return array(
			'leaderboards' => $leaderboards,
			'names'        => $names,
		);
	}
}

?>
