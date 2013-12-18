<?php

class leaderboards extends UserModule
{
	public function __default()
	{
		// Grabs the user's leaderboards
		$leaderboards = $this->redis->zrevrange('user:' . $this->uid . ':leaderboards:updated', 0, -1, 'WITHSCORES');
		$data         = array();

		if ($leaderboards)
		{
			$this->redis->multi();

			$leaderboard_uids = array();

			foreach ($leaderboards as $uid => $updated_at)
			{
				$leaderboard_uids[] = $uid;
				$this->redis->hmget('leaderboard:' . $uid, array('name', 'created_at'));
			}

			$data = array_combine($leaderboard_uids, $this->redis->exec());
		}

		return array(
			'leaderboards' => $leaderboards,
			'data'         => $data,
		);
	}
}

?>
