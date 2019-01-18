<?php
class Controller_Myprofileshow extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      die(json_encode($res));
    }
    $res['usr_id'] = $usr_id;
    $res = DB::query("select count(*) from follow where receiver = ".$usr_id." AND status = 2")->execute()->as_array();
    $res['follower'] = $res[0]['count'];
    $res = DB::query("select count(*) from follow where sender = ".$usr_id." AND status = 2")->execute()->as_array();
    $res['following'] = $res[0]['count'];
    $r = DB::query("select * from usr where id = ".$usr_id)->execute()->as_array();
    $res['introduce'] = ( isset($r[0]['introduce']) ) ? $r[0]['introduce'] : '';
    $res['myname'] = ( isset($r[0]['name']) ) ? $r[0]['name'] : '';
    $res['nice'] = ( isset($r[0]['nice']) ) ? $r[0]['nice'] : 0;
    $res['certify'] = ( isset($r[0]['certify']) ) ? $r[0]['certify'] : 0;
    $res['amt_quiz'] = ( isset($r[0]['quiz']) ) ? $r[0]['quiz'] : 0;
    $res['amt_forum'] = ( isset($r[0]['forum']) ) ? $r[0]['forum'] + $r[0]['forum_comment'] : 0;
    
    $r = DB::query("select count(*) as cnt from answer_key_u where usr_id = ".$usr_id)->execute()->as_array();
    $res['amt_answer'] = $r[0]['cnt'];

    $res['forum'] = DB::query("select * from forum where usr_id = ".$usr_id)->execute()->as_array();
    $res['forum_comment'] = DB::query("select * from forum_comment where usr_id = ".$usr_id)->execute()->as_array();

//    $profile_fb_url = 'https://www.facebook.com/sharer.php?u=https://'
//      .Config::get('my.domain')
//      .'/profile/?u='
//      .$usr_id
//      .'%26cpn=share_fb'
//      ;
//    $profile_tw_url = 'https://twitter.com/intent/tweet?url=https://'
//      .Config::get('my.domain')
//      .'/profile/?u='
//      .$usr_id
//      .'%26cpn=share_tw&text='
//      .$introduce
//      .'+@quigen2015'
//      ;
//    $profile_ln_url = 'line://msg/text/?'
//      .$introduce
//      .'%0D%0Ahttps://'
//      .Config::get('my.domain')
//      .'/profile/?u='
//      .$usr_id
//      .'%26cpn=share_ln'
//      ;
//    $profile_clip_url = 'https://'.Config::get('my.domain').'/profile/?u='.$usr_id;
    
//    $view->fb_url = 'https://www.facebook.com/dialog/oauth?client_id='
//      .Config::get('my.fb_id')
//      .'&redirect_uri=https://'
//      .$_SERVER['HTTP_HOST']
//      .'/fboauth/'
//      ;
//    $view->gp_url = 'https://accounts.google.com/o/oauth2/auth'
//      .'?client_id='.Config::get('my.gp_id')
//      .'&response_type=code'    
//      .'&scope=openid'    
//      .'&redirect_uri='.Config::get('my.gp_callback')    
//      ;
    $arr_list = [];
    $day = [];
    $msg_usr = [];

    $arr_forum = [];
    $arr = DB::query("select * from forum where usr_id = ".$usr_id." order by open_time desc")->execute()->as_array();
    foreach ($arr as $k => $d) {
      $arr1['forum_id'] = $d['id'];
      $arr1['txt'] = $d['txt'];
      $arr1['img'] = $d['img'];
      $date = new DateTime($d['open_time']);
      $arr1['open_time'] = $date->format('M/jS').' '.$date->format('D');
      $arr1['no_param'] = $d['no_param'];
      $arr_list[$d['open_time']] = $arr1;
    }
    $res['forum'] = $arr_forum;
    
    $arr_forum_comment = [];
    $arr = DB::query("select * from forum_comment where usr_id = ".$usr_id." order by open_time desc")->execute()->as_array();
    foreach ($arr as $k => $d) {
      $arr1['forum_id'] = $d['forum_id'];
      $arr1['txt'] = $d['txt'];
      $arr1['img'] = $d['img'];
      $date = new DateTime($d['open_time']);
      $arr1['open_time'] = $date->format('M/jS').' '.$date->format('D');
      $arr1['no_param'] = 0;
      $arr_forum_comment[$d['open_time']] = $arr1;
    }
    krsort($arr_forum_comment);
    $res['forum_comment'] = $arr_forum_comment;
    $date = new DateTime();
    $i = 0;
    while ($i < 61) {
      $key_day = $date->format('M/jS');
      $arr1['day'] = $key_day.' '.$date->format('D');
      $arr1['answer'] = 0;
      $arr1['spend'] = 0;
      $day[$key_day] = $arr1;
      $date->sub(new DateInterval('P1D'));
      ++$i;
    }
    $sql = "SELECT * FROM answer_by_day WHERE usr_id = "
              .$usr_id." AND day < '".date("Y-m-d H:i:s")."' AND day > '".date("Y-m-d H:i:s",strtotime('-61 day'))."'"
              ." ORDER BY day DESC";
    $arr = DB::query($sql)->execute()->as_array();
    $max = 1;
    foreach ($arr as $k => $d) {
      $date = new DateTime($d['day']);
      $key_day = $date->format('M/jS');
      $day[$key_day]['day'] = $key_day.' '.$date->format('D');
      if ( isset($day[$key_day]['answer']) ) {
        $day[$key_day]['answer'] = $day[$key_day]['answer'] + $d['answer'];
        $day[$key_day]['spend'] = $day[$key_day]['spend'] + $d['spend'];            
      } else {
        $day[$key_day]['answer'] = $d['answer'];
        $day[$key_day]['spend'] = $d['spend'];            
      }
      $day[$key_day]['time'] = Model_Time::s2h($day[$key_day]['spend']);
      if ($day[$key_day]['answer'] > $max) {
        $max = $day[$key_day]['answer'];
      }
    }
    $res['max'] = $max;
    $res['day'] = $day;

    $sql = "SELECT sender, receiver, u_img FROM message WHERE sender = ".$usr_id." OR receiver = ".$usr_id." GROUP BY sender, receiver, u_img";
    $arr = DB::query($sql)->execute()->as_array();
    foreach ($arr as $d) {
      if ($usr_id != $d['sender']) {
        $usr = $d['sender'];
      }
      if ($usr_id != $d['receiver']) {
        $usr = $d['receiver'];
      }
      $msg_usr[$usr] = $d;
      $msg_usr[$usr]['usr_id'] = $usr;
    }
    $res['msg_usr'] = $msg_usr;
//    $view->arr_list = $arr_list;
    
//    $view->msg_usr = $msg_usr;
//    $view->introduce = $introduce;
//    $view->list = $list;
//    $view->profile_fb_url = $profile_fb_url;
//    $view->profile_tw_url = $profile_tw_url;
//    $view->profile_ln_url = $profile_ln_url;
//    $view->profile_clip_url = $profile_clip_url;
//    $view->u_id = $usr_id;
    die(json_encode($res));
  }
}
