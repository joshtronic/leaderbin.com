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
		'session'         => 'files',
		'template'        => 'index',
		'module'          => 'home',
		//'404'             => 'error/404',
		'datasource'      => 'mysql',
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
			'memcached' => array(
				'type'      => 'memcache',
				'hostname'  => 'localhost',
				'port'      => 11211,
				'namespace' => 'ELLBEE',
			),
			'mysql' => array(
				'type'     => 'mysql',
				'driver'   => 'pdo_mysql',
				'hostname' => 'localhost',
				'username' => 'root',
				'password' => '',
				'database' => 'leaderbin',
				'cache'    => false,
			),
			'redis' => array(
				'type'      => 'redis',
				'hostname'  => 'localhost',
				'port'      => 6379,
				'database'  => '0',
				'namespace' => 'lb',
			),
		),
		'production' => array(
			'memcached' => array(
				'type'      => 'memcache',
				'hostname'  => 'localhost',
				'port'      => 11211,
				'namespace' => 'ELLBEE',
			),
			'mysql' => array(
				'type'     => 'mysql',
				'driver'   => 'pdo_mysql',
				'hostname' => 'localhost',
				'username' => 'leaderbin',
				'password' => '9f48580930bdcaf13c1888cd946e809e75ab8d90',
				'database' => 'leaderbin',
				'cache'    => false,
			),
			'redis' => array(
				'type'      => 'redis',
				'hostname'  => 'localhost',
				'port'      => 6381,
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
);

?>
