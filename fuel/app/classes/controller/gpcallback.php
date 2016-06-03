<?php
class Controller_GpCallback extends Controller
{
  public function action_index()
  {
    $post_data = array(
      'code' => $_GET['code'],
      'client_id' => Config::get('my.gp_id'),
      'client_secret' => Config::get('my.gp_secret'),
      'redirect_uri' => Config::get('my.gp_callback'),
      'grant_type' => 'authorization_code',
    );

    $curl = curl_init("https://accounts.google.com/o/oauth2/token");
    curl_setopt($curl,CURLOPT_POST, TRUE);
    // ↓はmultipartリクエストを許可していないサーバの場合はダメっぽいです
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);
    //curl_setopt($curl, CURLOPT_WRITEFUNCTION, 'write_callback') ;
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $output = curl_exec($curl);
    
    if (curl_errno($curl)) {
      die( curl_errno($curl) );
    } else {
      curl_close($curl);
    }
    $output = json_decode($output);
    $contents = file_get_contents('https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$output->access_token);
    $contents = json_decode($contents);
    $id = $contents->user_id;
    $usr_id = Model_Cookie::get_usr('u_id');

    $arr_pv_usr = DB::query("SELECT * FROM usr WHERE pv_u_id = '".$id."' AND provider = 3 ")->execute()->as_array();
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
      $usr_id = $usr_id ?: $usr->get_new_id();
      $usr->id = $usr_id;
      $usr->pv_u_id = $id;
      $usr->provider = 3;
      $usr->name = $myname = '';
      $usr->img = $myphoto = '';
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
        $arr_myanswer[] = [$d['question_id'],$d['result'],urlencode($d['q_txt']),$d['q_img'],1];
      }
    }
    $js_answer_by_u = json_encode([$correct,$total]);
    $js_answer = json_encode($arr_myanswer);
    $arr_offline_q = [];
    foreach ($arr_answer as $k => $d) {
     if ($k < 200) {
        $arr_offline_q[] = [
            urlencode($d['q_txt'])
            ,$d['choice_0']
            ,$d['choice_1']
            ,$d['choice_2']
            ,$d['choice_3']
            ,$d['correct_choice']
            ,$d['q_img']
            ,(string)$d['question_id']
            ,urlencode($d['comment'])
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
    Model_Cookie::set_usr($usr_id);
    
    $view = View::forge('oauth');

    $view->follow = json_encode($arr);
    $view->myname = Security::htmlentities($myname);
    $view->myphoto = Security::htmlentities($myphoto);
    $view->point = $point;
    $view->js_answer = $js_answer;
    $view->js_offline_q = $js_offline_q;
    $view->js_answer_by_u = $js_answer_by_u;
    $view->introduce = urlencode($introduce);

    $view->u_id = $usr_id;
    die($view);
  }
}
