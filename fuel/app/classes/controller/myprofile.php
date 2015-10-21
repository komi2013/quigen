<?php
class Controller_Myprofile extends Controller
{
  public function action_index()
  {
    $view = View::forge('myprofile');
    $view->follower = 0;
    $usr_id = Model_Cookie::get_usr();
    if ($usr_id)
    {
      $res = DB::query("select count(*) from follow where receiver = ".$usr_id." AND status = 2")
        ->execute()->as_array();
      $view->follower = $res[0]['count'];
      $res = DB::query("select * from usr where id = ".$usr_id)->execute()->as_array();
      $view->introduce = ( isset($res[0]['introduce']) ) ? $res[0]['introduce'] : '';
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
    
    $view->u_id = $usr_id;
    die($view);
  }
}
