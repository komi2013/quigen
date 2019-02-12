<?php
return array(

	'default_timezone'   => 'Asia/Tokyo',
	'log_threshold'    => Fuel::L_WARNING,
	'security' => array(
		'uri_filter'       => array('htmlentities'),
		'output_filter'  => array('Security::htmlentities'),
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
    ),
	'package_paths' => array(
		PKGPATH
	),
	'always_load'  => array(
      'packages'  => array(
		 	  'orm',
      ),
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
    'tw_callback' => 'https://english.quigen.info/twcallback/',
    'tw_access' => '2864849020-ushWEkxm1jD6J6FLVtNKPJqTFikauSivtdTigMg',
    'tw_access_secret' => 'uoAR9SB61hiSmObe9Zehl7XjcU8PaW9r1ecLHYt0sGHQc',

    'gp_id' => '330926095143-8qaioeb9n2bsu7t9e14nljdme2gu8l3q.apps.googleusercontent.com',
    'gp_secret' => 'kUbSjgn5qksNaR4AFzjAqm9N',
    'gp_callback' => 'https://english.quigen.info/gpcallback/',
    'gp_login' => 'https://english.quigen.info/gplogin/',

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
      
    'dir' => '/var/www/english/',
      
    'top_title' => "Quigen. let's English study together on the world",
    'top_description' => 'You can answer from 4 choices, able to make your question, chat with anyone who study english all of the world',
    'forum_list_title' => "Let's share your episode or opinion through learning english",
    'forum_list_description' => 'If you post your comment, teacher correct your part of wrong comment. you can get used to english more ',
    'top_limit' => '2',
      
    'display_error' => false,
    'lang' => 'en',
    'cache_v' => "?cache_v=2",
//https://console.firebase.google.com/project/first-c2036/settings/cloudmessaging/android:first.test.komatsuseijiro.com?hl=ja
    'push_key' => 'AAAAQ4U9QiY:APA91bGSYhGZD4z_gOhkx5wdbVrRmhHt_6ETd7Vb4nm_mN0-fkTeiIHknXdKtiD2XZXbjX2AiDhjwYK3ScJTlZtyCXr2tA0tmlV3ebl2yk3LlUbgCQaaQnU-9BRY3JVfy4DhpHqkKCuY',
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
    'please_login' => 'please login',
    'calling' => 'calling',
  ),
);
