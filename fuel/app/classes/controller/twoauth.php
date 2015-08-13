<?php
class Controller_TwOAuth extends Controller
{
	public function action_index()
	{
    require APPPATH.'vendor/tw/twitteroauth/twitteroauth.php';
    $consumer_key = Config::get('my.tw_key');
    $consumer_secret = Config::get('my.tw_secret');
    $to = new TwitterOAuth($consumer_key,$consumer_secret);
    $tok = $to->getRequestToken(Config::get('my.tw_callback'));
    Cookie::set('request_token',$tok['oauth_token']);
    Cookie::set('request_token_secret',$tok['oauth_token_secret']);
    $url = $to->getAuthorizeURL($tok['oauth_token']);
    Response::redirect($url);
	}
}
