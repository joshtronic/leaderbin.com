<?php

class leaderboards extends UserModule
{
	public function __default()
	{
		// Grabs the user's leaderboards
		$leaderboards = $this->redis->zrevrange('user:' . $this->uid . ':leaderboards:updated', 0, -1, 'WITHSCORES');

		if ($leaderboards)
		{
			$this->redis->multi();

			// Grabs the additional fields
			foreach ($leaderboards as $uid => $updated_at)
			{
				unset($leaderboards[$uid]);
				$leaderboards[(int)$uid] = $updated_at;

				$this->redis->hmget('leaderboard:' . $uid, array('name', 'created_at'));
			}

			$fields = $this->redis->exec();

			foreach ($leaderboards as $uid => $updated_at)
			{
				$data = current($fields);

				$leaderboards[$uid] = array(
					'name'       => $data['name'],
					'created_at' => (int)$data['created_at'],
					'updated_at' => (int)$updated_at,
				);

				next($fields);
			}
		}

		return array('leaderboards' => $leaderboards);
	}
}

?>
