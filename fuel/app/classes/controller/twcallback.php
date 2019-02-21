<?php
require APPPATH.'vendor/twitteroauth-1.0.1/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
class Controller_TwCallback extends Controller
{
  public function action_index()
  {
    $consumer_key = Config::get('my.tw_key');
    $consumer_secret = Config::get('my.tw_secret');
    $request_token = [];
    $request_token['oauth_token'] = Cookie::get('oauth_token');  //Cookie::get('oauth_token_secret')
    $request_token['oauth_token_secret'] = Cookie::get('oauth_token_secret');

    if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
        die( 'Error!' );
    }

    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);

    $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $user = $connection->get("account/verify_credentials");

    $id = $access_token['user_id'];
    $arr_pv_usr = DB::query("SELECT * FROM usr WHERE pv_u_id = '".$id."' AND provider = 2 ")->execute()->as_array();
    $follow = [];
    $myname = '';
    $myphoto = '';
    $point = '';
    $js_answer = [];
    $js_answer_by_u = [];
    $introduce = '';
    echo '<pre>'; var_dump($access_token); echo '</pre>'; die;
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
      $usr_id = isset($usr_id) ? $usr_id : $usr->get_new_id();
      $usr->id = $usr_id;
      $usr->pv_u_id = $id;
      $usr->provider = 2;
      $usr->name = $myname = $access_token['screen_name'];
<<<<<<< HEAD
      $usr->img = $myphoto = $access_token['profile_image_url_https'];
=======
      $usr->img = $myphoto = $user->profile_image_url_https;
>>>>>>> 524184bc4e53a3a4460a4fe8ebfd22ffbd593f6b
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
    $view->js_answer = $js_answer;
    $view->js_offline_q = $js_offline_q;
    $view->arr_offline_q = $arr_offline_q;
    $view->js_answer_by_u = $js_answer_by_u;
    $view->introduce = urlencode($introduce);

    $view->u_id = $usr_id;
    die($view);
  }
}
