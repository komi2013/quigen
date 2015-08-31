<?php
class Controller_Forum extends Controller
{
  public function action_index()
  {
    if ( isset($_GET['f']) AND is_numeric($_GET['f']) ) {
      $arr = DB::select()->from('forum')
              ->where('id','=',$_GET['f'])
              ->or_where('parent_id','=',$_GET['f'])
              ->order_by('open_time', 'desc')
              ->execute()->as_array();
      if ( isset($arr[0]['id']) ) {
        $forum_id =  $arr[0]['id'];
        $f_txt = $arr[0]['txt'];
        $f_img = $arr[0]['img'];
        $f_u_id = $arr[0]['usr_id'];
      } else {
        $view = View::forge('404');
        die($view);
      }
    } else {
      $view = View::forge('404');
      die($view);
    }
    $view = View::forge('forum');
    Model_Csrf::setcsrf();
    $f_txt = Security::htmlentities($f_txt);
    $view->img = $f_img;
    $view->question = $question_id;
    $view->usr = $f_u_id;
    $view->fb_url = 'http://www.facebook.com/sharer.php?u=http://'.
        Config::get('my.domain').
        '/forum/?f='.
        $question_id.'%26cpn=share_fb';
    $view->tw_url = 
        'https://twitter.com/intent/tweet?url=http://'.
        Config::get('my.domain').
        '/forum/?f='.$question_id.'%26cpn=share_tw'.
        '&text='.
        $f_txt.','.$description.'+@quigen2015';
    $view->ln_url = 'line://msg/text/?'.
        $f_txt.
        '%0D%0Ahttp://'.
        Config::get('my.domain').
        '/forum/?q='.
        $question_id.'%26cpn=share_ln';
    $view->clip_url = 'http://'.
        Config::get('my.domain').
        '/forum/?q='.
        $question_id;
    $view->description = $description;
    $view->f_txt = $f_txt;
    $view->u_id = Model_Cookie::get_usr();
    die($view);
  }
}
