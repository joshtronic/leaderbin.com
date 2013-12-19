<?php

class api_v1_leaderboard extends APIv1
{
	protected $request_methods = array('GET', 'POST', 'PUT');

	public function __default()
	{
		try
		{
			// Checks if we have a UID
			if (!isset($_GET['uid']))
			{
				throw new Exception('Missing UID.');
			}

			$leaderboard_uid = $_GET['uid'];
			$leaderboard_key = 'leaderboard:' . $leaderboard_uid;

			// Checks that the UID is valid and belongs to the key
			$leaderboard = $this->redis->hgetall($leaderboard_key);

			if (!$leaderboard)
			{
				throw new Exception('Leaderboard UID does not exist.');
			}

			if ($this->uid != $leaderboard['uid'])
			{
				throw new Exception('Leaderboard UID does not belong to you.');
			}

			// Sets up our key suffixes
			list($year, $month, $day, $week) = explode('-', date('Y-m-d-W'));

			$week  = $year . $week;
			$day   = $year . $month . $day;
			$month = $year . $month;

			$suffixes = array(
				'day:' . $day,
				'week:' . $week,
				'month:' . $month,
				'year:' . $year,
				'alltime',
			);

			switch ($_SERVER['REQUEST_METHOD'])
			{
				// Pulls members of the leaderboard
				case 'GET':
					$members = $this->redis->zrevrange($leaderboard_key . ':alltime', 0, -1, 'WITHSCORES');

					return array('leaderboard' => array_merge($leaderboard, array('members' => $members)));
					break;

				// Adds a score for a member
				case 'POST':
					if (!isset($_POST['member']))
					{
						throw new Exception('Missing member.');
					}
					elseif (!isset($_POST['score']))
					{
						throw new Exception('Missing score.');
					}
					elseif (!preg_match('/^-?\d+$/', $_POST['score']))
					{
						throw new Exception('Score must be an integer.');
					}

					$this->redis->multi();

					foreach ($suffixes as $suffix)
					{
						$this->redis->zadd($leaderboard_key . ':' . $suffix, $_POST['score'], $_POST['member']);
					}

					$timestamp = time();

					foreach (array('', 'user:' . $this->uid . ':') as $prefix)
					{
						$this->redis->zadd($prefix . 'leaderboards:updated', $timestamp, $leaderboard_uid);
					}
					break;

				// Increments a score of a member
				case 'PUT':
					$increment = 1;

					if (!isset($_REQUEST['member']))
					{
						throw new Exception('Missing member.');
					}
					elseif (isset($_REQUEST['value']))
					{
						if (!preg_match('/^-?\d+$/', $_REQUEST['value']))
						{
							throw new Exception('Value must be an integer.');
						}

						$increment = $_REQUEST['value'];
					}

					$this->redis->multi();

					foreach ($suffixes as $suffix)
					{
						$this->redis->zincrby($leaderboard_key . ':' . $suffix, $increment, $_REQUEST['member']);
					}

					$timestamp = time();

					foreach (array('', 'user:' . $this->uid . ':') as $prefix)
					{
						$this->redis->zadd($prefix . 'leaderboards:updated', $timestamp, $leaderboard_uid);
					}

					$this->redis->exec();
					break;
			}
		}
		catch (Exception $e)
		{
			return array('response_code' => 400, 'error' => $e->getMessage());
		}
	}
}

?>
