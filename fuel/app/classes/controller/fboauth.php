<?php
class Controller_FbOAuth extends Controller
{
  public function action_index()
  {
    $client_id = Config::get('my.fb_id');
    $client_secret = Config::get('my.fb_secret');

    $fb_url = 'https://graph.facebook.com/oauth/access_token?';
    $redirect_uri = 'redirect_uri=http://'.$_SERVER['HTTP_HOST'].'/fboauth/&';

    $contents = file_get_contents($fb_url.'client_id='.$client_id.'&'.$redirect_uri.'client_secret='.$client_secret.'&code='.$_GET['code']);

    $arr_url = preg_split('/=/', $contents, -1, PREG_SPLIT_OFFSET_CAPTURE);
    $contents = file_get_contents('https://graph.facebook.com/me?access_token='.$arr_url[1][0]);
    $contents = json_decode($contents);
    $id = $contents->id;
    $arr_pv_usr = DB::query("SELECT * FROM usr WHERE pv_u_id = '".$id."' AND provider = 1 ")->execute()->as_array();
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
      $usr_id = $usr->get_new_id();
      $usr->id = $usr_id;
      $usr->pv_u_id = $id;
      $usr->provider = 1;
      $usr->name = $myname = $contents->name;
      $usr->img = $myphoto = 'http://graph.facebook.com/'.$id.'/picture';
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
    Cookie::set('myname', Security::htmlentities($myname) );
    Cookie::set('myphoto', Security::htmlentities($myphoto));
    Cookie::set('point', $point);
    Cookie::set('answer', $json_answer);
    Cookie::set('answer_by_u', $json_answer_by_u);
    Model_Cookie::set_usr($usr_id);
    Cookie::set('ua_u_id', $usr_id);
    Response::redirect('/myprofile/');
  }
}
