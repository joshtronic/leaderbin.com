<?php

$config = array(
	// {{{ Environments

	'environments' => array(
		'local'      => 'local.leaderbin.com',
		'production' => 'leaderbin.com',
	),

	// }}}
	// {{{ PHP Options

	'php' => array(
		'local' => array(
			'date.timezone'          => 'Universal',
			'display_errors'         => true,
			'error_reporting'        => -1,
			'session.gc_maxlifetime' => 86400,
		),
		'production' => array(
			'date.timezone'          => 'Universal',
			'display_errors'         => false,
			'error_reporting'        => -1,
			'session.gc_maxlifetime' => 86400,
		),
	),

	// }}}
	// {{{ PICKLES Stuff

	'pickles' => array(
		'disabled'        => false,
		'session'         => false,
		'template'        => 'index',
		'module'          => 'home',
		//'404'             => 'error/404',
		'datasource'      => false,
		'cache'           => 'memcached',
		'profiler'        => array(
			'local'       => false,
			'production'  => false,
		),
		'logging'         => array(
			'local'       => true,
			'production'  => false,
		),
		'minify'          => array(
			'local'       => true,
			'production'  => false,
		),
	),

	// }}}
	// {{{ Datasources

	'datasources' => array(
		'local' => array(
			'redis' => array(
				'type'      => 'redis',
				'hostname'  => '127.0.0.1',
				'port'      => 6379,
				'database'  => '0',
				'namespace' => 'lb',
			),
		),
		'production' => array(
			'redis' => array(
				'type'      => 'redis',
				'hostname'  => '127.0.0.1',
				'port'      => 6380,
				'database'  => '0',
				'namespace' => 'lb',
			),
		),
	),

	// }}}
	// {{{ Security Options

	'security' => array(
		'login'  => 'login',
		'model'  => 'User',
		'column' => 'role',
		'levels' => array(
			 0 => 'ANONYMOUS',
			10 => 'USER',
			20 => 'ADMIN',
		),
	),

	// }}}
	'site' => array(
		'name'   => 'LeaderBin',
		'domain' => 'leaderbin.com',
	),
	'api' => array(
		'ayah' => array(
			'publisher_key' => '12605450c23a1a6cff00b387ffe673dd9d2a27fe',
			'scoring_key'   => '79b499385530453f43026ec58347564bbc08b8c2',
		),
	),
);

?>
