<?php
require APPPATH.'vendor/twitteroauth-1.0.1/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
class Controller_TwOAuth extends Controller
{
  public function action_index()
  {
    $consumer_key = Config::get('my.tw_key');
    $consumer_secret = Config::get('my.tw_secret');
    $connection = new TwitterOAuth($consumer_key,$consumer_secret);
    //コールバックURLをここでセット
    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => 'https://'.Config::get('my.domain').'/twcallback/' ));

    //callback.phpで使うのでセッションに入れる
//    $_SESSION['oauth_token'] = $request_token['oauth_token'];
//    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    Cookie::set('oauth_token',$request_token['oauth_token']);
    Cookie::set('oauth_token_secret',$request_token['oauth_token_secret']);
    

    //Twitter.com 上の認証画面のURLを取得( この行についてはコメント欄も参照 )
    $url = $connection->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));

    //Twitter.com の認証画面へリダイレクト
    header( 'location: '. $url );
  }
}
