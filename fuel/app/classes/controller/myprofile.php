<?php
class Controller_Myprofile extends Controller
{
  public function action_index()
  {
    $view = View::forge('myprofile');
    $view->follower = 0;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      die(View::forge('404'));
    }

    $res = DB::query("select count(*) from follow where receiver = ".$usr_id." AND status = 2")->execute()->as_array();
    $view->follower = $res[0]['count'];
    $res = DB::query("select count(*) from follow where sender = ".$usr_id." AND status = 2")->execute()->as_array();
    $view->following = $res[0]['count'];
    $res = DB::query("select * from usr where id = ".$usr_id)->execute()->as_array();
    $introduce = ( isset($res[0]['introduce']) ) ? $res[0]['introduce'] : '';
    $view->myname = ( isset($res[0]['name']) ) ? $res[0]['name'] : '';
    $view->nice = ( isset($res[0]['nice']) ) ? $res[0]['nice'] : 0;
    $view->certify = ( isset($res[0]['certify']) ) ? $res[0]['certify'] : 0;
    $view->amt_quiz = ( isset($res[0]['quiz']) ) ? $res[0]['quiz'] : 0;
    $view->amt_forum = ( isset($res[0]['forum']) ) ? $res[0]['forum'] + $res[0]['forum_comment'] : 0;
    
    $res = DB::query("select count(*) as cnt from answer_key_u where usr_id = ".$usr_id)->execute()->as_array();
    $view->amt_answer = $res[0]['cnt'];

    $view->forum = DB::query("select * from forum where usr_id = ".$usr_id)->execute()->as_array();
    $view->forum_comment = DB::query("select * from forum_comment where usr_id = ".$usr_id)->execute()->as_array();

    $profile_fb_url = 'http://www.facebook.com/sharer.php?u=http://'
      .Config::get('my.domain')
      .'/profile/?u='
      .$usr_id
      .'%26cpn=share_fb'
      ;
    $profile_tw_url = 'https://twitter.com/intent/tweet?url=http://'
      .Config::get('my.domain')
      .'/profile/?u='
      .$usr_id
      .'%26cpn=share_tw&text='
      .$introduce
      .'+@quigen2015'
      ;
    $profile_ln_url = 'line://msg/text/?'
      .$introduce
      .'%0D%0Ahttp://'
      .Config::get('my.domain')
      .'/profile/?u='
      .$usr_id
      .'%26cpn=share_ln'
      ;
    $profile_clip_url = 'http://'.Config::get('my.domain').'/profile/?u='.$usr_id;
    
    $view->fb_url = 'https://www.facebook.com/dialog/oauth?client_id='
      .Config::get('my.fb_id')
      .'&redirect_uri=http://'
      .$_SERVER['HTTP_HOST']
      .'/fboauth/'
      ;
    $view->gp_url = 'https://accounts.google.com/o/oauth2/auth'
      .'?client_id='.Config::get('my.gp_id')
      .'&response_type=code'    
      .'&scope=openid'    
      .'&redirect_uri='.Config::get('my.gp_callback')    
      ;
    $list = '';
    $arr_list = []; $day = []; $msg_usr = [];
    if ( isset($_GET['list']) AND $_GET['list'] == 'quiz') {
      $list = 'quiz';
    } else if ( isset($_GET['list']) AND $_GET['list'] == 'forum') {
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
      $arr = DB::query("select * from forum_comment where usr_id = ".$usr_id." order by open_time desc")->execute()->as_array();
      foreach ($arr as $k => $d) {
        $arr1['forum_id'] = $d['forum_id'];
        $arr1['txt'] = $d['txt'];
        $arr1['img'] = $d['img'];
        $date = new DateTime($d['open_time']);
        $arr1['open_time'] = $date->format('M/jS').' '.$date->format('D');
        $arr1['no_param'] = 0;
        $arr_list[$d['open_time']] = $arr1;
      }
      krsort($arr_list);
      $list = 'forum';
    } else if ( isset($_GET['list']) AND $_GET['list'] == 'graph') {
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
      $view->max = $max;
      $list = 'graph';
    } else if ( isset($_GET['list']) AND $_GET['list'] == 'msg') {
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
      $list = 'msg';
    }
    $view->arr_list = $arr_list;
    $view->day = $day;
    $view->msg_usr = $msg_usr;
    $view->introduce = $introduce;
    $view->list = $list;
    $view->profile_fb_url = $profile_fb_url;
    $view->profile_tw_url = $profile_tw_url;
    $view->profile_ln_url = $profile_ln_url;
    $view->profile_clip_url = $profile_clip_url;
    $view->u_id = $usr_id;
    die($view);
  }
}
