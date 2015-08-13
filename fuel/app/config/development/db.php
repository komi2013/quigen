<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => "pgsql:host=localhost dbname=quiz-stg ",
			'username'   => 'postgres',
			'password'   => '',
		),
	),
);
