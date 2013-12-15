<?php

class user_create extends CustomModule
{
	//protected $ajax     = true;
	//protected $method   = 'POST';
	//protected $validate = array(
	//	'username' => array(
	//		'length:>:30'             => 'Usernames may not be more than 30 characters.',
	//		'regex:is:/[^a-z0-9-]+/i' => 'Usernames may only contain alphanumeric characters or dashes.',
	//		'regex:is:/^(-.+|.+-)$/'  => 'Usernames may not start or end with a dash.',
	//		'regex:is:/-{2,}/'        => 'Usernames may not have two or more dashes in a row.',
	//	),
	//	'email' => array(
	//		'length:>:100'            => 'Email addresses may not be more than 100 characters.',
	//		'filter:email'            => 'Your email address is invalid.',
	//	),
	//	'password' => array(
	//		'length:<:8'              => 'Passwords may not be less than 8 characters.',
	//	),
	//);

	public function __default()
	{
		var_dump($this->redis->set('test', sha1(microtime(true))));
		var_dump($this->redis->get('test'));
		var_dump($this->redis->info());
	}
}

?>
