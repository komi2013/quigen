<?php
return array(
        '_root_'  => 'top/index',  // The default route
        '_404_'   => '404',    // The main 404 route
        'htm/(:one)' => 'htm/all/$1',
        'sitemap/dynamic/(:tag)' => 'sitemap/dynamic/$1',

);