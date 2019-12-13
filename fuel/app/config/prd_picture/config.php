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
    'domain' => 'picture.quigen.info',
    'sitemap' => 's3V-64fqf7q7n0h1RNvJARHEBvbrIocNaH7tos3JzWU',

    'fb_id' => '284457388571956',
    'fb_secret' => '723dbfe077fc90099c402a8dbd9b0778',

    'tw_key' => 'u8oFfE0332okfOfN0xT3KzgqX',
    'tw_secret' => 'os5RRoVGsrnSPxeyEFHb7nEX1dmKO8fGXF7zdMrrVkqWoOe7pd',
    'tw_callback' => 'https://picture.quigen.info/twcallback/',
    'tw_access' => '2864849020-ushWEkxm1jD6J6FLVtNKPJqTFikauSivtdTigMg',
    'tw_access_secret' => 'uoAR9SB61hiSmObe9Zehl7XjcU8PaW9r1ecLHYt0sGHQc',

    'gp_id' => '330926095143-8qaioeb9n2bsu7t9e14nljdme2gu8l3q.apps.googleusercontent.com',
    'gp_secret' => 'kUbSjgn5qksNaR4AFzjAqm9N',
    'gp_callback' => 'https://picture.quigen.info/gpcallback/',
    'gp_login' => 'https://picture.quigen.info/gplogin/',

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
      
    'dir' => '/var/www/picture/',
      
    'top_title' => "幼児から小学生まで写真・絵で単語を覚えよう",
    'top_description' => '一回タップすると画像が表示して、音が出るのでどれが正解かを答えよう',
    'forum_list_title' => "ここになんでも書き込んでてください",
    'forum_list_description' => 'クイズの質問や、このアプリについても回答します',
    'top_limit' => '5',
      
    'display_error' => true,
    'lang' => 'jp',
    'cache_v' => "?cache_v=35",
//https://console.firebase.google.com/project/first-c2036/settings/cloudmessaging/android:first.test.komatsuseijiro.com?hl=ja
    'push_key' => 'AAAAQ4U9QiY:APA91bGSYhGZD4z_gOhkx5wdbVrRmhHt_6ETd7Vb4nm_mN0-fkTeiIHknXdKtiD2XZXbjX2AiDhjwYK3ScJTlZtyCXr2tA0tmlV3ebl2yk3LlUbgCQaaQnU-9BRY3JVfy4DhpHqkKCuY',
  ),
  'lang' => array(
    'you_can_answer_after_this_time' => 'この時間まで待ってください',
    'answer_first' => '答えてください',
    'not_enough_point' => 'ポイント不足',
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
