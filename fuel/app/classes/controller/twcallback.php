<?php
class Controller_TwCallback extends Controller
{
  public function action_index()
  {
    require APPPATH.'vendor/tw/twitteroauth/twitteroauth.php';
    $consumer_key = Config::get('my.tw_key');
    $consumer_secret = Config::get('my.tw_secret');
    
    $verifier = $_GET['oauth_verifier'];
    
    $to = new TwitterOAuth($consumer_key,$consumer_secret,Cookie::get('request_token'),Cookie::get('request_token_secret'));
    $access_token = $to->getAccessToken($verifier);
    $to->host = 'https://api.twitter.com/1.1/'; // By default library uses API version 1.  
    $profile = $to->get('/users/show.json?screen_name='.$access_token['screen_name'].'&user_id='.$access_token['user_id']);
    $id = $access_token['user_id'];
    $arr_pv_usr = DB::query("SELECT * FROM usr WHERE pv_u_id = '".$id."' AND provider = 2 ")->execute()->as_array();
    if ( isset($arr_pv_usr[0]['id']) ) {
      if ( isset($usr_id) AND $usr_id != $arr_pv_usr[0]['id']) {
        Response::redirect('/myprofile/?warn=logout');
      }
      $usr_id  = $arr_pv_usr[0]['id'];
      $point   = $arr_pv_usr[0]['point'];
      $myname  = $arr_pv_usr[0]['name'];
      $myphoto = $arr_pv_usr[0]['img'];
    } else {
      $usr = new Model_Usr();
      $usr_id = $usr_id ?: $usr->get_new_id();
      $usr->id = $usr_id;
      $usr->pv_u_id = $id;
      $usr->provider = 2;
      $usr->name = $myname = $access_token['screen_name'];
      $usr->img = $myphoto = $profile->profile_image_url_https;
      $usr->update_at = date("Y-m-d H:i:s");
      $usr->save();
      $point = 0;
    }
    $arr_answer = DB::query("SELECT * FROM answer_key_u WHERE usr_id = ".$usr_id." ORDER BY create_at desc")->execute()->as_array();
    $correct = 0; $total = 0;
    $arr_myanswer = [];
    foreach ($arr_answer as $k => $d) {
      $correct = $correct*1 + $d['result']*1;
      ++$total;
      $arr_myanswer[] = [$d['question_id'],$d['result'],$d['q_txt'],$d['q_img'],1];
    }
    $json_answer_by_u = json_encode([$correct,$total]);
    $json_answer = json_encode($arr_myanswer);

    $arr_follow = DB::query("select receiver from follow where sender = ".$usr_id)->execute()->as_array();
    $arr = array();
    foreach ($arr_follow as $d)
    {
      $arr[] = $d['receiver'];
    }
    Cookie::set('follow', json_encode($arr));
    Cookie::set('myname', Security::htmlentities($myname));
    Cookie::set('myphoto', Security::htmlentities($myphoto));
    Cookie::set('point', $point);
    Cookie::set('answer', $json_answer);
    Cookie::set('answer_by_u', $json_answer_by_u);
    Model_Cookie::set_usr($usr_id);
    Cookie::set('ua_u_id', $usr_id);
    Response::redirect('/myprofile/');
  }
}
