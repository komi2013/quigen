<?php
class Controller_Forum extends Controller
{
  public function action_index()
  {
    if ( isset($_GET['f']) AND is_numeric($_GET['f']) ) {
      $arr = DB::select()->from('forum')
              ->where('id','=',$_GET['f'])
              ->or_where('parent_id','=',$_GET['f'])
              ->order_by('open_time', 'asc')
              ->execute()->as_array();
    } else {
      $view = View::forge('404');
      die($view);
    }
    Model_Csrf::setcsrf();
    $arr_forum = [];
    $description = '';
    $util = new Model_Util();
    foreach ($arr as $k => $d) {
      $arr_forum[$k] = $d;
      if ($d['u_img']) {
        $arr_forum[$k]['eto_css'] = '';
      } else {
        $util->eto($d['usr_id']);
        $arr_forum[$k]['u_img'] = $util->eto_img;
        $arr_forum[$k]['eto_css'] = $util->eto_css;
      }
      if ($k < 5) {
        $description .= $d['txt'];  
      }
    }
    
    //echo '<pre>'; var_dump($arr_forum); echo '</pre>'; die;
    $view = View::forge('forum');
    Model_Csrf::setcsrf();
    $view->f_id = $_GET['f'];
    $view->title = $arr_forum[0]['txt'];
    $view->description = $description;
    $view->forum = $arr_forum;
    $view->u_id = Model_Cookie::get_usr();
    die($view);
  }
}
