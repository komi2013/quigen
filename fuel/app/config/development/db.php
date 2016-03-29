<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => "pgsql:host=localhost dbname=juken_stg ",
			'username'   => 'postgres',
			'password'   => '',
		),
	),
);
