<?php
class Controller_Myprofile extends Controller
{
  public function action_index()
  {
    $view = View::forge('myprofile');
    $view->follower = 0;
    $usr_id = Model_Cookie::get_usr();
    $profile_fb_url = '';
    $profile_tw_url = '';
    $profile_ln_url = '';
    $profile_clip_url = '';
    $introduce = '';
    $myname = '';

    if ($usr_id) {
      $res = DB::query("select count(*) from follow where receiver = ".$usr_id." AND status = 2")
        ->execute()->as_array();
      $view->follower = $res[0]['count'];
      $res = DB::query("select * from usr where id = ".$usr_id)->execute()->as_array();
      $introduce = ( isset($res[0]['introduce']) ) ? $res[0]['introduce'] : '';
      $myname = ( isset($res[0]['name']) ) ? $res[0]['name'] : '';

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
    }
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
    
    $view->profile_fb_url = $profile_fb_url;
    $view->profile_tw_url = $profile_tw_url;
    $view->profile_ln_url = $profile_ln_url;
    $view->profile_clip_url = $profile_clip_url;
    $view->introduce = $introduce;
    $view->myname = $myname;
    $view->u_id = $usr_id;
    die($view);
  }
}
