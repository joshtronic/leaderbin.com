<?php

class leaderboard_edit extends leaderboards
{
	public function __default()
	{
		try
		{
			$return       = parent::__default();
			$leaderboards = $return['leaderboards'];

			if (!isset($_GET['uid']))
			{
				throw new Exception('Missing UID.');
			}

			if (!isset($leaderboards[$_GET['uid']]))
			{
				throw new Exception('Leaderboard does not belong to you.');
			}

			return array('leaderboard' => $leaderboards[$_GET['uid']]);
		}
		catch (Exception $e)
		{
			exit($e->getMessage());
		}
	}
}

?>
