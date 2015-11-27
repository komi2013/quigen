<?php
return array(
	'_root_'  => 'top/index',  // The default route
	'_404_'   => '404',    // The main 404 route
        'htm/(:any)' => array('htm/all', 'name' => 'all'),
        'sitemap2/(:any)' => array('sitemap2/all', 'name' => 'all'),
// 	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);