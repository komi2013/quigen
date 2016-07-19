<?php
return array(
	// 'base_url'  => null,
	// 'url_suffix'  => '',
	// 'index_file' => false,
	// 'profiling'  => false,
	// 'cache_dir'       => APPPATH.'cache/',
	// 'caching'         => false,
	// 'cache_lifetime'  => 3600, // In Seconds
	// 'ob_callback'  => null,
	// 'errors'  => array(
		// Which errors should we show, but continue execution? You can add the following:
		// E_NOTICE, E_WARNING, E_DEPRECATED, E_STRICT to mimic PHP's default behaviour
		// (which is to continue on non-fatal errors). We consider this bad practice.
		// 'continue_on'  => array(),
		// How many errors should we show before we stop showing them? (prevents out-of-memory errors)
		// 'throttle'     => 10,
		// Should notices from Error::notice() be shown?
		// 'notices'      => true,
		// Render previous contents or show it as HTML?
		// 'render_prior' => false,
	// ),
	// 'language'           => 'en', // Default language
	// 'language_fallback'  => 'en', // Fallback language when file isn't available for default language
	// 'locale'             => 'en_US', // PHP set_locale() setting, null to not set
	//'encoding'  => 'UTF-8',
	// 'server_gmt_offset'  => 0,
	'default_timezone'   => 'Asia/Tokyo',
	'log_threshold'    => Fuel::L_WARNING,
	// 'log_path'         => APPPATH.'logs/',
	// 'log_date_format'  => 'Y-m-d H:i:s',
	'security' => array(
		// 'csrf_autoload'    => false,
		// 'csrf_token_key'   => 'fuel_csrf_token',
		// 'csrf_expiration'  => 0,
		// 'token_salt'            => 'put your salt value here to make the token more secure',
		// 'allow_x_headers'       => false,
		'uri_filter'       => array('htmlentities'),
		// 'input_filter'  => array(),
		'output_filter'  => array('Security::htmlentities'),
		// 'htmlentities_flags' => ENT_QUOTES,
		// 'htmlentities_double_encode' => false,
		'auto_filter_output'  => false,
		'whitelisted_classes' => array(
			'Fuel\\Core\\Presenter',
			'Fuel\\Core\\Response',
			'Fuel\\Core\\View',
			'Fuel\\Core\\ViewModel',
			'Closure',
		),
	),
    'cookie' => array(
  		  'expiration'  => 365 * 24 * 60 * 60,
  		 'path'        => '/',
  		// Restrict the domain that the cookie is available to
  		// 'domain'      => null,
  		// Only transmit cookies over secure connections
  		// 'secure'      => false,
  		// Only transmit cookies over HTTP, disabling Javascript access
  		// 'http_only'   => false,
    ),
	// 'validation' => array(
		// 'global_input_fallback' => true,
	// ),
	 // 'controller_prefix' => 'Controller_',
	// 'routing' => array(
		// 'case_sensitive' => true,
		// 'strip_extension' => true,
	// ),
	// 'module_paths' => array(
	// 	//APPPATH.'modules'.DS
	// ),
	'package_paths' => array(
		PKGPATH
	),
	'always_load'  => array(
      'packages'  => array(
		 	  'orm',
      ),
		// 'modules'  => array(),
		// 'classes'  => array(),
		// 'config'  => array(),
		// 'language'  => array(),
  ),
  'crypt_key' => array(
    'cookie' => 'Ydjome@feF',
    'correct' => 'PdslkmkklD',
    'q_data' => 'IkoDoQpZeflIW',
  ),

  'my' => array(
    'domain' => 'english.quigen.info',
    'sitemap' => 's3V-64fqf7q7n0h1RNvJARHEBvbrIocNaH7tos3JzWU',

    'fb_id' => '284457388571956',
    'fb_secret' => '723dbfe077fc90099c402a8dbd9b0778',

    'tw_key' => 'u8oFfE0332okfOfN0xT3KzgqX',
    'tw_secret' => 'os5RRoVGsrnSPxeyEFHb7nEX1dmKO8fGXF7zdMrrVkqWoOe7pd',
    'tw_callback' => 'http://english.quigen.info/twcallback/',
    'tw_access' => '2864849020-ushWEkxm1jD6J6FLVtNKPJqTFikauSivtdTigMg',
    'tw_access_secret' => 'uoAR9SB61hiSmObe9Zehl7XjcU8PaW9r1ecLHYt0sGHQc',

    'gp_id' => '330926095143-8qaioeb9n2bsu7t9e14nljdme2gu8l3q.apps.googleusercontent.com',
    'gp_secret' => 'kUbSjgn5qksNaR4AFzjAqm9N',
    'gp_callback' => 'http://english.quigen.info/gpcallback/',
    'gp_login' => 'http://english.quigen.info/gplogin/',

    'adm' => array(
        11  //facebook komatsuka@yahoo.com
        ,22 // twitter seijirok@gmail.com
        ,33  // google plus seijirok@gmail.com
      ),

    'ua' => 'UA-57298122-1',

    'Paypal_SandboxFlag' => true,
    'Paypal_API_UserName' => 'komatsuka-facilitator_api1.yahoo.com',
    'Paypal_API_Password' => 'DMYTDA2YFPHFEYTQ',
    'Paypal_API_Signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AyQJuBHTexT7KPc8sRK6HQBPx51I',
    'Paypal_API_Endpoint' => 'https://api-3t.sandbox.paypal.com/nvp',
    'PAYPAL_URL' => 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=',
    'PAYPAL_DG_URL' => 'https://www.sandbox.paypal.com/incontext?token=',
      
    'dir' => '/prd/english/',
      
    'top_title' => "Quigen. let's English study together on the world",
    'top_description' => 'You can answer from 4 choices, able to make your question, chat with anyone who study english all of the world',
    'forum_list_title' => "Let's share your episode or opinion through learning english",
    'forum_list_description' => 'You can get used to english. If you post text, people might correct your text if it is wrong. ',
    'top_limit' => '2',
      
    'display_error' => false,
  ),

);
