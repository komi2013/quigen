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
      if ($k < 200) {
        $arr_myanswer[] = [$d['question_id'],$d['result'],$d['q_txt'],$d['q_img'],1];
      }
    }
    $js_answer_by_u = json_encode([$correct,$total]);
    $js_answer = json_encode($arr_myanswer);
    /*
     * for login, it is necessary to add 2 columns answer_key_u  
     * after all oauth function need to be changed
     *      */
//    offline_q.unshift([
//   0   $('#question').html()  
//   1   ,$('#choice_0').html()
//   2   ,$('#choice_1').html()
//   3   ,$('#choice_2').html()
//   4   ,$('#choice_3').html()
//   5   ,correct
//   6   ,$('#photo').attr('src')
//   7   ,q_id
//   8   ,comment_offline
//   9   ,$(this_seq).html()  my answer
//    ]);
//    $arr_offline_q = [];
//    foreach ($arr_answer as $k => $d) {
//     if ($k < 200) {
//        $arr_offline_q[] = [
//            $d['q_txt']
//            ,$d['result']
//            ,$d['q_txt']
//            ,$d['q_img']
//            ,1
//          ];
//      }
//    }
    $arr_follow = DB::query("select receiver from follow where sender = ".$usr_id)->execute()->as_array();
    $arr = array();
    foreach ($arr_follow as $d) {
      $arr[] = $d['receiver'];
    }
    Model_Cookie::set_usr($usr_id);
    
    $view = View::forge('oauth');

    $view->follow = json_encode($arr);
    $view->myname = Security::htmlentities($myname);
    $view->myphoto = Security::htmlentities($myphoto);
    $view->point = $point;
    $view->js_answer = $js_answer;
    $view->js_answer_by_u = $js_answer_by_u;
    $view->introduce = urlencode($introduce);

    $view->u_id = $usr_id;
    die($view);
  }
}
