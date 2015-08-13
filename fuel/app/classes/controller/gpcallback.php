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
