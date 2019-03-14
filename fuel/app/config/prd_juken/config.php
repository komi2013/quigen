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
	// 'encoding'  => 'UTF-8',

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
	// 'log_threshold'    => Fuel::L_WARNING,
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

	/**
	 * To enable you to split up your application into modules which can be
	 * routed by the first uri segment you have to define their basepaths
	 * here. By default empty, but to use them you can add something
	 * like this:
	 *      array(APPPATH.'modules'.DS)
	 *
	 * Paths MUST end with a directory separator (the DS constant)!
	 */
	// 'module_paths' => array(
	// 	//APPPATH.'modules'.DS
	// ),

	/**
	 * To enable you to split up your additions to the framework, packages are
	 * used. You can define the basepaths for your packages here. By default
	 * empty, but to use them you can add something like this:
	 *      array(APPPATH.'modules'.DS)
	 *
	 * Paths MUST end with a directory separator (the DS constant)!
	 */
	'package_paths' => array(
		PKGPATH
	),


	/**************************************************************************/
	/* Always Load                                                            */
	/**************************************************************************/
	'always_load'  => array(

		/**
		 * These packages are loaded on Fuel's startup.
		 * You can specify them in the following manner:
		 *
		 * array('auth'); // This will assume the packages are in PKGPATH
		 *
		 * // Use this format to specify the path to the package explicitly
		 * array(
		 *     array('auth'	=> PKGPATH.'auth/')
		 * );
		 */
      'packages'  => array(
		 	  'orm',
      ),

		/**
		 * These modules are always loaded on Fuel's startup. You can specify them
		 * in the following manner:
		 *
		 * array('module_name');
		 *
		 * A path must be set in module_paths for this to work.
		 */
		// 'modules'  => array(),

		/**
		 * Classes to autoload & initialize even when not used
		 */
		// 'classes'  => array(),

		/**
		 * Configs to autoload
		 *
		 * Examples: if you want to load 'session' config into a group 'session' you only have to
		 * add 'session'. If you want to add it to another group (example: 'auth') you have to
		 * add it like 'session' => 'auth'.
		 * If you don't want the config in a group use null as groupname.
		 */
		// 'config'  => array(),

		/**
		 * Language files to autoload
		 *
		 * Examples: if you want to load 'validation' lang into a group 'validation' you only have to
		 * add 'validation'. If you want to add it to another group (example: 'forms') you have to
		 * add it like 'validation' => 'forms'.
		 * If you don't want the lang in a group use null as groupname.
		 */
		// 'language'  => array(),
    
      
    
  ),
  'crypt_key' => array(
    'cookie' => 'Idsfk@qflyhnkq',
    'correct' => 'Xdfloqpmdktyw',
    'q_data' => 'dkoDoQpZeflIq',
  ),

  'my' => array(
    'domain' => 'juken.quigen.info',
    'sitemap' => '',

    'fb_id' => '1460997554206402',
    'fb_secret' => '63c63a3d47a248d7806807e06be45e57',
    'fb_access_eng' => 'CAACdPVtBJwkBAHlMwega9lyNZAoCfCC3ewtqNlRMPWTIzdwB6bZBti9ZCkgaoD9edydOkT0ywCSKz26JB9y8EhGlZARdsc4T82zc73cSBAPqBabxLLhXoS0U2m4wQQA3Jhvo9Egi8NHEOx8i5NSflJdCbhZASOdMut2j14aq0SODxwQFOZAWdnsTvMbbhh7IkZD',
    'fb_access_his' => 'CAACdPVtBJwkBAHZBSWNdqx8PqZA6PmXPOY4ZCvKCFF1SgBBtzsKMySVWLQNsvT4UqOEZABvY11dFb15BTDyhcEfaUnKWjIpC9oxSM044qLhQk2FsnvvrGv2GO7CZAaKumwwZAwyIghdoso0i7A6tGVln4w1J2GGjo1b9dLaVsp7EUHxJUcVKrzB2VnEYlPwjsZD',

    'tw_key' => 'mFiNn1AulUfkMgAmuCV0FVJoV',
    'tw_secret' => 'N0GL6v2hHN4T8bp0SmcisZkU76CjaKHr6N8ojE2J9u76qXjoMm',
    'tw_callback' => 'https://juken.quigen.info/twcallback/',
    'tw_access' => '2864849020-e1kyCRpZj42grGkQUiRVvxx8l39DwOQoXOmb4ju',
    'tw_access_secret' => 'gZ5YhhWkVVlV6s11qIrVmlOhPb0yKdb7x2WRvbhPPY1Uo',

    'gp_id' => '273637196335-kra4770crt5djul7v51f43vd0gvv2o0s.apps.googleusercontent.com',
    'gp_secret' => 'eOTFQ6Xc9-lomLnEnouDbCzP',
    'gp_callback' => 'https://juken.quigen.info/gpcallback/',
    'gp_login' => 'https://juken.quigen.info/gplogin/',

    'adm' => array(
        11  //facebook komatsuka@yahoo.com
        ,22 // twitter seijirok@gmail.com
        ,33  // google plus seijirok@gmail.com
      ),

    'ua' => 'UA-57298122-1',
    'Paypal_SandboxFlag' => false,
    'Paypal_API_UserName' => 'komatsuka_api1.yahoo.com',
    'Paypal_API_Password' => 'G7EZ6SCP8GG8KNT9',
    'Paypal_API_Signature' => 'ARozKawd1-e0G-hxDSJJR-hj7WA8ArmlCtrbpGORlL6OmHRG1Ste1vVK',
    'Paypal_API_Endpoint' => 'https://api-3t.paypal.com/nvp',
    'PAYPAL_URL' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=',
    'PAYPAL_DG_URL' => 'https://www.paypal.com/incontext?token=',

    'dir' => '/var/www/juken/',
      
    'top_title' => 'クイジェン | 大学受験の生物、日本史、世界史、英語の問題集',
    'top_description' => 'ログインなしで4択クイズに答えれます。クイズの内容はセンター試験の内容もあります。ランクも表示されます。自分でもプライベートクイズを作成できます。復習機能で単語も覚えやすいです。',
    'forum_list_title' => 'FAQ | 数学や英語などのわからない部分の画像をアップすれば、オンライン講師が教えてくれる',
    'forum_list_description' => 'わからない所が教科書や問題集にあった場合その画像をアップすれば他に見ている誰かが教えてくれるかも、簡単に画像を投稿できるのでためしにアップしてみては？',
    'top_limit' => '20',
      
    'display_error' => false,
    'lang' => 'jp',
    'cache_v' => "?cache_v=98",
//https://console.firebase.google.com/project/first-c2036/settings/cloudmessaging/android:first.test.komatsuseijiro.com?hl=ja
    'push_key' => 'AAAAQ4U9QiY:APA91bGSYhGZD4z_gOhkx5wdbVrRmhHt_6ETd7Vb4nm_mN0-fkTeiIHknXdKtiD2XZXbjX2AiDhjwYK3ScJTlZtyCXr2tA0tmlV3ebl2yk3LlUbgCQaaQnU-9BRY3JVfy4DhpHqkKCuY',
  ),
  'lang' => array(
    'you_can_answer_after_this_time' => 'この時間まで待ってください',
    'answer_first' => '答えてください',
    'not_enough_point' => 'ポイント不足',
    'thanks' => '<a href="/htm/news/">このページへ</a>',
    'delete' => '削除',
    'confirm' => 'いいですか？',
    'checked_chat' => 'チャット確認',
    'after' => '','hours_please' => '後に',
    'made_quiz' => '作成',
    'no_' => '', 'mon' => '問',
    'checked_offline' => 'オフライン確認',
    'please_logout' => 'ログアウトしてください',
    'checked_mypage' => 'マイページ確認',
    'login' => 'ログイン',
    'change_profile' => 'プロファイル変更',
    'logout' => 'ログアウト',
    'tag_category' => 'タグカテゴリ',
    'follow_confirm' => 'フォロー確認',
    'shared_quiz' => 'クイズのシェア',
    'commented' => 'コメント',
    'report' => '#レポート',
    'checked_rank' => 'ランク確認',
    'checked_top' => 'トップページ確認',
    'please_login' => 'ログインお願いします',
    'calling' => '呼び出し中',
    'no_point_for_msg' => "ポイントが足りません"."\r\n"."明日送信できます",
    'answered' => "回答",
    'total' => "全",
  ),
);
