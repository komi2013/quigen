<?php
class Controller_Forumlist extends Controller
{
  public function action_index()
  {
    $view = View::forge('forum_list');
    $usr_id = Model_Cookie::get_usr();
    $offset = 0;
    $unit = 20;
    $next_page = 0;
    if ( isset($_GET['page']) ) {
      $offset = $_GET['page'] * $unit;
      $next_page = $_GET['page'];
    }
    if ( isset($_GET['page']) AND $_GET['page'] == 0) {
      die( View::forge('404') );
    }
    $arr = DB::select()->from('forum')
      ->where('open_time','<',date('Y-m-d H:i:s'))
      ->order_by('open_time', 'desc')
      ->limit($unit)->offset($offset)
      ->execute()->as_array();
    $arr_forum_id = [];
    $arr_forum = [];
    $util = new Model_Util();
    foreach ($arr as $k => $d) {
      $arr_forum_id[] = $d['id'];
      $arr_forum[$d['id']] = $d;
      $arr_forum[$d['id']]['arr_comment'] = [];
      $arr_forum[$d['id']]['comment_amt'] = 0;
      $arr_forum[$d['id']]['view_all'] = false;
      
      if ($d['u_img']) {
        $arr_forum[$d['id']]['eto_css'] = '';
      } else {
        $util->eto($d['usr_id']);
        $arr_forum[$d['id']]['u_name'] = $util->eto_txt;
        $arr_forum[$d['id']]['u_img'] = $util->eto_img;
        $arr_forum[$d['id']]['eto_css'] = $util->eto_css;
      }
    }
    if (!isset($k)) {
      die( View::forge('404') );
    }
    if ($k == $unit -1) {
      ++$next_page;
    } else {
      $next_page = 0;
    }
    $arr = DB::select()->from('forum_comment')
      ->where('forum_id','in',$arr_forum_id)
      ->order_by('open_time', 'asc')
      ->execute()->as_array();
    $arr2 = [];
    foreach ($arr as $d) {
      $arr2[$d['forum_id']][] = $d;
    }
    foreach ($arr2 as $k => $d) {
      $same_u_id = true;
      $comment_amt = 0;
      $arr3 = [];
      foreach ($d as $d2) {
        if ($arr_forum[$d2['forum_id']]['usr_id'] != $d2['usr_id']) {
          $same_u_id = false;
        }
        if ($same_u_id) {
          $arr_forum[$d2['forum_id']]['view_all'] = true; 
        } else {
          $arr_forum[$d2['forum_id']]['comment_amt'] = ++$comment_amt;
          $arr3[] = $d2;
        }
      }
      krsort($arr3);
      $arr4 = [];
      $i = 0;
      foreach ($arr3 as $k3 => $d3) {
        if ($k3 < 3) {
          $arr4[$i] = $d3;
          $arr4[$i]['txt'] = Str::truncate(Security::htmlentities($d3['txt']),60);
          $arr4[$i]['eto_css'] = '';
          if (!$d3['u_img']) {
            $util->eto($d3['usr_id']);
            $arr4[$i]['u_img'] = $util->eto_img;
            $arr4[$i]['eto_css'] = $util->eto_css;
          }
          ++$i;
        } else {
          $arr_forum[$d3['forum_id']]['view_all'] = true; 
        }
      }
      krsort($arr4);
      $arr_forum[$k]['arr_comment'] = $arr4;
    }
    $view->arr_forum = $arr_forum;
    $view->next_page = $next_page;
    $view->js_forum_id = json_encode($arr_forum_id);
    $view->u_id = $usr_id;
    die($view);
  }
}
