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
    $view->amt_forum = ( isset($res[0]['forum']) ) ? $res[0]['forum'] : 0;
    $view->amt_forum_comment = ( isset($res[0]['forum_comment']) ) ? $res[0]['forum_comment'] : 0;
    
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
    $arr_list = [];
    if ( isset($_GET['list']) AND $_GET['list'] == 'quiz') {
      $list = 'quiz';
    } else if ( isset($_GET['list']) AND $_GET['list'] == 'forum') {
      $arr_list = DB::query("select * from forum where usr_id = ".$usr_id)->execute()->as_array();
      $list = 'forum';
    } else if ( isset($_GET['list']) AND $_GET['list'] == 'forum_comment') {
      $arr_list = DB::query("select * from forum_comment where usr_id = ".$usr_id)->execute()->as_array();
      $list = 'forum_comment';
    }
    foreach ($arr_list as $k => $d) {
      $arr_list[$k] = $d;
      $date = new DateTime($d['open_time']);
      $arr_list[$k]['open_time'] = $date->format('Y-m-d H');
    }
    $view->arr_list = $arr_list;
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
