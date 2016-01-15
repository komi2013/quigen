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
    'domain' => 'shikaku.quigen.info',
    'sitemap' => 's3V-64fqf7q7n0h1RNvJARHEBvbrIocNaH7tos3JzWU',

    'fb_id' => '1688503281371952',
    'fb_secret' => 'ce5a324b3e6d38c9e21ffb2c545d2058',

    'tw_key' => 'RYk3vRhp2agjW5pOqYcTkRSGb',
    'tw_secret' => 'YyeQiBTlnswdsZn9Vil1drxllxsYJgYBe7AhpDVVo1qR9FD9FX',
    'tw_callback' => 'http://shikaku.quigen.info/twcallback/',
    'tw_access' => '2864849020-Xa38CqNBpvMXTi9MuC6bpFRvaOhUPqIyz98l2wy',
    'tw_access_secret' => 'MRVVF8HMh7zRlgWJZRYHloDQU9DnZvClTGferZVBT0xSx',

    'gp_id' => '527982563510-2i8h8q76jkupd8nrvf5evkv244o2kqe6.apps.googleusercontent.com',
    'gp_secret' => 'xM76uzRTXEMcgAcRCaCe4rH_',
    'gp_callback' => 'http://shikaku.quigen.info/gpcallback/',
    'gp_login' => 'http://shikaku.quigen.info/gplogin/',

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
      
    'dir' => '/prd/shikaku/',
      
    'top_title' => '資格の問題集、中国語検定、TOEICなど | クイジェン',
    'top_description' => '中国語、ロシア語、ドイツ語、フランス語、中国語の発音、通関士、スペイン語、TOEIC英単語などの問題をクイズ形式で答えて暗記できます',
    'forum_list_title' => 'FAQ | 中国語の文法などのわからない部分の画像をアップすれば教えてくれるかも',
    'forum_list_description' => 'わからない所が教科書や問題集にあった場合その画像をアップすれば他に見ている誰かが教えてくれるかも、簡単に画像を投稿できるのでためしにアップしてみては？',
    'top_limit' => '10',
  ),

);
