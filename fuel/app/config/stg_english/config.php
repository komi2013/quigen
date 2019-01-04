<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */


return array(

	/**
	 * base_url - The base URL of the application.
	 * MUST contain a trailing slash (/)
	 *
	 * You can set this to a full or relative URL:
	 *
	 *     'base_url' => '/foo/',
	 *     'base_url' => 'http://foo.com/'
	 *
	 * Set this to null to have it automatically detected.
	 */
	// 'base_url'  => null,

	/**
	 * url_suffix - Any suffix that needs to be added to
	 * URL's generated by Fuel. If the suffix is an extension,
	 * make sure to include the dot
	 *
	 *     'url_suffix' => '.html',
	 *
	 * Set this to an empty string if no suffix is used
	 */
	// 'url_suffix'  => '',

	/**
	 * index_file - The name of the main bootstrap file.
	 *
	 * Set this to 'index.php if you don't use URL rewriting
	 */
	// 'index_file' => false,

	// 'profiling'  => false,

	/**
	 * Default location for the file cache
	 */
	// 'cache_dir'       => APPPATH.'cache/',

	/**
	 * Settings for the file finder cache (the Cache class has it's own config!)
	 */
	// 'caching'         => false,
	// 'cache_lifetime'  => 3600, // In Seconds

	/**
	 * Callback to use with ob_start(), set this to 'ob_gzhandler' for gzip encoding of output
	 */
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

	/**
	 * Localization & internationalization settings
	 */
	// 'language'           => 'en', // Default language
	// 'language_fallback'  => 'en', // Fallback language when file isn't available for default language
	// 'locale'             => 'en_US', // PHP set_locale() setting, null to not set

	/**
	 * Internal string encoding charset
	 */
	//'encoding'  => 'UTF-8',

	/**
	 * DateTime settings
	 *
	 * server_gmt_offset	in seconds the server offset from gmt timestamp when time() is used
	 * default_timezone		optional, if you want to change the server's default timezone
	 */
	// 'server_gmt_offset'  => 0,
	'default_timezone'   => 'Asia/Tokyo',

	/**
	 * Logging Threshold.  Can be set to any of the following:
	 *
	 * Fuel::L_NONE
	 * Fuel::L_ERROR
	 * Fuel::L_WARNING
	 * Fuel::L_DEBUG
	 * Fuel::L_INFO
	 * Fuel::L_ALL
	 */
	'log_threshold'    => Fuel::L_WARNING,
	// 'log_path'         => APPPATH.'logs/',
	// 'log_date_format'  => 'Y-m-d H:i:s',

	/**
	 * Security settings
	 */
	'security' => array(
		// 'csrf_autoload'    => false,
		// 'csrf_token_key'   => 'fuel_csrf_token',
		// 'csrf_expiration'  => 0,

		/**
		 * A salt to make sure the generated security tokens are not predictable
		 */
		// 'token_salt'            => 'put your salt value here to make the token more secure',

		/**
		 * Allow the Input class to use X headers when present
		 *
		 * Examples of these are HTTP_X_FORWARDED_FOR and HTTP_X_FORWARDED_PROTO, which
		 * can be faked which could have security implications
		 */
		// 'allow_x_headers'       => false,

		/**
		 * This input filter can be any normal PHP function as well as 'xss_clean'
		 *
		 * WARNING: Using xss_clean will cause a performance hit.
		 * How much is dependant on how much input data there is.
		 */
		'uri_filter'       => array('htmlentities'),

		/**
		 * This input filter can be any normal PHP function as well as 'xss_clean'
		 *
		 * WARNING: Using xss_clean will cause a performance hit.
		 * How much is dependant on how much input data there is.
		 */
		// 'input_filter'  => array(),

		/**
		 * This output filter can be any normal PHP function as well as 'xss_clean'
		 *
		 * WARNING: Using xss_clean will cause a performance hit.
		 * How much is dependant on how much input data there is.
		 */
		'output_filter'  => array('Security::htmlentities'),

		/**
		 * Encoding mechanism to use on htmlentities()
		 */
		// 'htmlentities_flags' => ENT_QUOTES,

		/**
		 * Wether to encode HTML entities as well
		 */
		// 'htmlentities_double_encode' => false,

		/**
		 * Whether to automatically filter view data
		 */
		'auto_filter_output'  => false,

		/**
		 * With output encoding switched on all objects passed will be converted to strings or
		 * throw exceptions unless they are instances of the classes in this array.
		 */
		'whitelisted_classes' => array(
			'Fuel\\Core\\Presenter',
			'Fuel\\Core\\Response',
			'Fuel\\Core\\View',
			'Fuel\\Core\\ViewModel',
			'Closure',
		),
	),

	/**
	 * Cookie settings
	 */
    'cookie' => array(
  		// Number of seconds before the cookie expires
  		  'expiration'  => 365 * 24 * 60 * 60,
  		// Restrict the path that the cookie is available to
  		 'path'        => '/',
  		// Restrict the domain that the cookie is available to
  		// 'domain'      => null,
  		// Only transmit cookies over secure connections
  		// 'secure'      => false,
  		// Only transmit cookies over HTTP, disabling Javascript access
  		// 'http_only'   => false,
    ),

	/**
	 * Validation settings
	 */
	// 'validation' => array(
		/**
		 * Wether to fallback to global when a value is not found in the input array.
		 */
		// 'global_input_fallback' => true,
	// ),

	/**
	 * Controller class prefix
	 */
	 // 'controller_prefix' => 'Controller_',

	/**
	 * Routing settings
	 */
	// 'routing' => array(
		/**
		 * Whether URI routing is case sensitive or not
		 */
		// 'case_sensitive' => true,

		/**
		 *  Wether to strip the extension
		 */
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
    'cookie' => 'Qdjsme@ffY',
    'correct' => 'Pdslkmkkll',
    'q_data' => 'dkoDoQpZeflIq',
  ),

  'my' => array(
    'domain' => 'zstg-english.quigen.info',
    'sitemap' => 's3V-64fqf7q7n0h1RNvJARHEBvbrIocNaH7tos3JzWU',

    'fb_id' => '1212985642054775',
    'fb_secret' => 'f88276168295f0f4efdfc3421ece7944',

    'tw_key' => 'bQRI6emWEmsqJZ46CCnoyRCTA',
    'tw_secret' => 'er9BHX0sqkDCrAyV9hTIBKJTqCfigZ7qpNRr7nxQEar3Tps5wh',
    'tw_callback' => 'https://zstg-english.quigen.info/twcallback/',
    'tw_access' => '2864849020-yVk2qA42EhF042mWqzQj7tLrv2ERHxpNsGKj55b',
    'tw_access_secret' => 'G3xct3C4wZXvoHxGmuWSXDqbFwMOpPZ6uG8vEEltb3spu',

    'gp_id' => '680215777007-8ph080ejb43s6eqke232rg3tqu1fgjs8.apps.googleusercontent.com',
    'gp_secret' => 'GAGkwYIYBbmfSNr7UELOMwsI',
    'gp_callback' => 'https://zstg-english.quigen.info/gpcallback/',
    'gp_login' => 'https://zstg-english.quigen.info/gplogin/',

    'adm' => array(
        11  //facebook komatsuka@yahoo.com
        ,22 // twitter seijirok@gmail.com
        ,33  // google plus seijirok@gmail.com
      ),

    'ua' => 'UA-57298122-2',

    'Paypal_SandboxFlag' => true,
    'Paypal_API_UserName' => 'komatsuka-facilitator_api1.yahoo.com',
    'Paypal_API_Password' => 'DMYTDA2YFPHFEYTQ',
    'Paypal_API_Signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AyQJuBHTexT7KPc8sRK6HQBPx51I',
    'Paypal_API_Endpoint' => 'https://api-3t.sandbox.paypal.com/nvp',
    'PAYPAL_URL' => 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=',
    'PAYPAL_DG_URL' => 'https://www.sandbox.paypal.com/incontext?token=',
      
    'dir' => '/var/www/zstg_english/',
      
    'top_title' => "Quigen. let's English study together on the world",
    'top_description' => 'You can answer from 4 choices, able to make your question, chat with anyone who study english all of the world',
    'forum_list_title' => "Let's share your episode or opinion through learning english",
    'forum_list_description' => 'You can get used to english. If you post text, people might correct your text if it is wrong. ',
    'top_limit' => '2',

    'display_error' => true,
    'lang' => 'en',
    'cache_v' => '?'.rand(0, 1000000000000000)
  ),
  'lang' => array(
    'you_can_answer_after_this_time' => 'you can answer after this time',
    'answer_first' => 'answer first',
    'not_enough_point' => 'not enough point',
    'thanks' => 'thanks. you will know <a href="/htm/?p=news">on this page</a>',
    'delete' => 'delete',
    'confirm' => 'confirm',
    'checked_chat' => 'checked chat',
    'after' => 'after ',' hours_please' => ' hours please',
    'made_quiz' => 'made quiz',
    'no_' => 'No.', 'mon' => '',
    'checked_offline' => 'checked offline',
    'please_logout' => 'please logout delete',
    'checked_mypage' => 'checked mypage',
    'login' => 'login synchronize',
    'change_profile' => 'change profile',
    'logout' => 'logout',
    'tag_category' => 'tag category',
    'follow_confirm' => 'follow confirm',
    'shared_quiz' => 'shared quiz',
    'commented' => 'commented',
    'report' => '#report ',
    'checked_rank' => 'checked rank',
    'checked_top' => 'checked top page',
  ),
);
