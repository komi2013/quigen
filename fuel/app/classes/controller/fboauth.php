<?php
class Controller_FbOAuth extends Controller
{
  public function action_index()
  {
    $client_id = Config::get('my.fb_id');
    $client_secret = Config::get('my.fb_secret');

    $fb_url = 'https://graph.facebook.com/oauth/access_token?';
    $redirect_uri = 'redirect_uri=https://'.$_SERVER['HTTP_HOST'].'/fboauth/&';

    $contents = file_get_contents($fb_url.'client_id='.$client_id.'&'.$redirect_uri.'client_secret='.$client_secret.'&code='.$_GET['code']);
    $contents = json_decode($contents,true);

    $contents = file_get_contents('https://graph.facebook.com/me?access_token='.$contents['access_token']);
    $contents = json_decode($contents);
    $id = $contents->id;
    $arr_pv_usr = DB::query("SELECT * FROM usr WHERE pv_u_id = '".$id."' AND provider = 1 ")->execute()->as_array();
    $follow = [];
    $myname = '';
    $myphoto = '';
    $point = '';
    $js_answer = [];
    $js_answer_by_u = [];
    $introduce = '';
    
    if ( isset($arr_pv_usr[0]['id']) ) {
      if ( isset($usr_id) AND $usr_id != $arr_pv_usr[0]['id']) {
        Response::redirect('/myprofile/?warn=logout');
      }
      $usr_id  = $arr_pv_usr[0]['id'];
      $point   = $arr_pv_usr[0]['point'];
      $myname  = $arr_pv_usr[0]['name'];
      $myphoto = $arr_pv_usr[0]['img'];
      $introduce = $arr_pv_usr[0]['introduce'];
    } else {
      $usr = new Model_Usr();
      $usr_id = $usr->get_new_id();
      $usr->id = $usr_id;
      $usr->pv_u_id = $id;
      $usr->provider = 1;
      $usr->name = $myname = $contents->name;
      $usr->img = $myphoto = 'https://graph.facebook.com/'.$id.'/picture';
      $usr->update_at = date("Y-m-d H:i:s");
      $usr->save();
      $point = 0;
    }
    $arr_answer = DB::query("SELECT * FROM answer_key_u WHERE usr_id = ".$usr_id." ORDER BY create_at desc")->execute()->as_array();
    $correct = 0; $total = 0;
    foreach ($arr_answer as $k => $d) {
      $correct = $correct*1 + $d['result']*1;
      ++$total;
    }
    $js_answer_by_u = json_encode([$correct,$total]);
    $arr_offline_q = [];
    foreach ($arr_answer as $k => $d) {
     if ($k < 200) {
        $arr_offline_q[] = [
            $d['q_txt']
            ,$d['choice_0']
            ,$d['choice_1']
            ,$d['choice_2']
            ,$d['choice_3']
            ,$d['correct_choice']
            ,$d['q_img']
            ,(string)$d['question_id']
            ,$d['comment']
            ,$d['myanswer']
            ,$d['quiz_num']
          ];
      }
    }
    $js_offline_q = json_encode($arr_offline_q);
    $arr_follow = DB::query("select receiver from follow where sender = ".$usr_id)->execute()->as_array();
    $arr = array();
    foreach ($arr_follow as $d) {
      $arr[] = $d['receiver'];
    }
    $geo = file_get_contents('http://ip-api.com/json/'.$_SERVER["REMOTE_ADDR"]);
    $geo = json_decode($geo,true);
    DB::update('usr')->value('latitude', $geo['lat'])->value('longitude', $geo['lon'])->where('id', $usr_id)->execute();
    Model_Cookie::set_usr($usr_id);
    
    $view = View::forge('oauth');

    $view->follow = json_encode($arr);
    $view->myname = Security::htmlentities($myname);
    $view->myphoto = Security::htmlentities($myphoto);
    $view->point = $point;
    $view->js_offline_q = $js_offline_q;
    $view->arr_offline_q = $arr_offline_q;
    $view->js_answer_by_u = $js_answer_by_u;
    $view->introduce = urlencode($introduce);

    $view->u_id = $usr_id;
    die($view);
  }
}
