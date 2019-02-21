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
    'domain' => 'shikaku.quigen.info',
    'sitemap' => 's3V-64fqf7q7n0h1RNvJARHEBvbrIocNaH7tos3JzWU',

    'fb_id' => '1688503281371952',
    'fb_secret' => 'ce5a324b3e6d38c9e21ffb2c545d2058',

    'tw_key' => 'RYk3vRhp2agjW5pOqYcTkRSGb',
    'tw_secret' => 'YyeQiBTlnswdsZn9Vil1drxllxsYJgYBe7AhpDVVo1qR9FD9FX',
    'tw_callback' => 'https://shikaku.quigen.info/twcallback/',
    'tw_access' => '2864849020-Xa38CqNBpvMXTi9MuC6bpFRvaOhUPqIyz98l2wy',
    'tw_access_secret' => 'MRVVF8HMh7zRlgWJZRYHloDQU9DnZvClTGferZVBT0xSx',

    'gp_id' => '527982563510-2i8h8q76jkupd8nrvf5evkv244o2kqe6.apps.googleusercontent.com',
    'gp_secret' => 'cie4WYM-K5Ab4TNFw3ZNnN3c',
    'gp_callback' => 'https://shikaku.quigen.info/gpcallback/',
    'gp_login' => 'https://shikaku.quigen.info/gplogin/',

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
      
    'dir' => '/var/www/shikaku/',
      
    'top_title' => '資格の問題集、中国語検定、TOEICなど | クイジェン',
    'top_description' => '中国語、ロシア語、ドイツ語、フランス語、中国語の発音、通関士、スペイン語、TOEIC英単語などの問題をクイズ形式で答えて暗記できます',
    'forum_list_title' => 'FAQ | 中国語の文法などのわからない部分の画像をアップすれば教えてくれるかも',
    'forum_list_description' => 'わからない所が教科書や問題集にあった場合その画像をアップすれば他に見ている誰かが教えてくれるかも、簡単に画像を投稿できるのでためしにアップしてみては？',
    'top_limit' => '10',
      
    'display_error' => false,
    'lang' => 'jp',
    'cache_v' => "?cache_v=98",
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
    'no_point_for_msg' => "you don't have enough point"."\r\n"."you can send tomorrow without point",
  ),
);
