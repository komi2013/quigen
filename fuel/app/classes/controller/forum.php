<?php
class Controller_Forum extends Controller
{
  public function action_index()
  {
    if ( isset($_GET['f']) AND is_numeric($_GET['f']) ) {
      $arr = DB::select()->from('forum')
              ->where('id','=',$_GET['f'])
              ->execute()->as_array();
    } else {
      $view = View::forge('404');
      die($view);
    }
    $arr_forum = [];
    $util = new Model_Util();
    $forum_u_id = 0;
    foreach ($arr as $k => $d) {
      $forum_u_id = $d['usr_id'];
      $d['esc_txt'] = htmlspecialchars($d['txt']);
      $d['u_img'] = htmlspecialchars($d['u_img']);
      $d['u_name'] = htmlspecialchars($d['u_name']);
      $arr_forum[0] = $d;
      if ($d['u_img']) {
        $arr_forum[0]['eto_css'] = '';
      } else {
        $util->eto($d['usr_id']);
        $arr_forum[0]['u_img'] = $util->eto_img;
        $arr_forum[0]['u_name'] = $util->eto_txt;
        $arr_forum[0]['eto_css'] = $util->eto_css;
      } 
      $title = $description = strip_tags($d['txt']);
      $forum_nice = $d['nice'];
      $forum_certify = $d['certify'];
    }
    if ( !isset($k) ) {
      $view = View::forge('404');
      die($view);
    }
    $arr = DB::select()->from('forum_comment')
      ->where('forum_id','=',$_GET['f'])
      ->order_by('open_time', 'asc')
      ->execute()->as_array();
    $arr_comment = [];
    $arr_comment_id = [];
    $same_u_id = true;
    foreach ($arr as $k => $d) {
      $d['esc_txt'] = htmlspecialchars($d['txt']);
      $d['u_img'] = htmlspecialchars($d['u_img']);
      $d['u_name'] = htmlspecialchars($d['u_name']);
      if ($d['usr_id'] == $forum_u_id AND $same_u_id) {
        $arr_forum[$k+1] = $d;
        if ($d['u_img']) {
          $arr_forum[$k+1]['eto_css'] = '';
        } else {
          $util->eto($d['usr_id']);
          $arr_forum[$k+1]['u_img'] = $util->eto_img;
          $arr_forum[$k+1]['eto_css'] = $util->eto_css;
        }
        $arr_forum[$k+1]['id'] = $d['forum_id'];
      } else {
        $same_u_id = false;
        $arr_comment[$d['id']] = $d;
        $arr_comment[$d['id']]['eto_css'] = '';
        if (!$d['u_img']) {
          $util->eto($d['usr_id']);
          $arr_comment[$d['id']]['u_img'] = $util->eto_img;
          $arr_comment[$d['id']]['u_name'] = $util->eto_txt;
          $arr_comment[$d['id']]['eto_css'] = $util->eto_css;
        }
        $arr_comment_id[] = $d['id'];
      }
      $description .= strip_tags($d['txt']);
    }
    
    $view = View::forge('forum');
    $view->fb_url = 'http://www.facebook.com/sharer.php?u=http://'.
        Config::get('my.domain').
        '/forum/?f='.
        $_GET['f'].'%26cpn=share_fb';
    $view->tw_url = 
        'https://twitter.com/intent/tweet?url=http://'.
        Config::get('my.domain').
        '/forum/?f='.$_GET['f'].'%26cpn=share_tw'.
        '&text='.
        $title.','.$description.'+@quigen2015';
    $view->clip_url = 'http://'.
        Config::get('my.domain').
        '/forum/?f='.
        $_GET['f'];
    $view->f_id = $_GET['f'];
    $view->title = $title;
    $view->description = Str::truncate($description,120);
    $view->arr_forum = $arr_forum;
    $view->arr_comment = $arr_comment;
    $view->js_comment_id = json_encode($arr_comment_id);
    $view->u_id = Model_Cookie::get_usr();
    $view->forum_nice = $forum_nice;
    $view->forum_certify = $forum_certify;
    die($view);
  }
}
