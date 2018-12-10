<?php
/**
 * The production database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'pgsql:host=localhost;dbname=juken',
			'username'   => 'postgres',
			'password'   => '',
		),
	),
);
