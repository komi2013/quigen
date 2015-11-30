<?php
return array(
	'_root_'  => 'top/index',  // The default route
	'_404_'   => '404',    // The main 404 route
        'htm/(:any)' => array('htm/all', 'name' => 'all'),
        'sitemap/dynamic/(:tag)' => 'sitemap/dynamic/$1', 
// 	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);