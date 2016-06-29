<?php
class Controller_Forumlist extends Controller
{
  public function action_index()
  {
    $view = View::forge('forum_list');
    $res = DB::query("SELECT count(*) FROM forum WHERE parent_id = 0 AND open_time < '".date('Y-m-d H:i:s')."'" )
      ->execute()->as_array();
    $this->cnt = ceil($res[0]['count']/10);
    $this->usr_id = Model_Cookie::get_usr();
    if ( isset($_GET['page']) ) {
      $page = $_GET['page'];
      $view->page = $page;
      $offset = ($this->cnt - $page + 1) * 10;
      if ($page > 1 AND $offset > 0) {
        $forum = [];
        $forum = DB::select()->from('forum')
          ->where('open_time','<',date('Y-m-d H:i:s'))
          ->and_where('parent_id','=',0)
          ->order_by('open_time', 'desc')
          ->limit(10)->offset($offset)
          ->execute()->as_array();
        $view->forum = $forum;
        $view->u_id = $this->usr_id;
        die($view);
      } else {
        $this->top_forum();
      }
    } else {
      $this->top_forum();
    }
  }
  public function top_forum()
  {
    $view = View::forge('forum_top');
    $forum = DB::select()->from('forum')
      ->where('open_time','<',date('Y-m-d H:i:s'))
      ->and_where('parent_id','=',0)
      ->order_by('open_time', 'desc')
      ->limit(10)
      ->execute()->as_array();
    $arr = [];
    foreach ($forum as $k => $d) {
      $arr[$k] = $d;
      $arr[$k]['txt'] = $d['txt'];
    }
    
    $query = DB::query("SELECT * FROM (
      SELECT tag, count(*) FROM tag_rank GROUP BY tag
        ) as rank
      ORDER BY rank.count DESC ")->execute()->as_array();
    $arr_tag = [];
    foreach ($query as $k => $d) {
      $arr_tag[$k] = $d;
      $arr_tag[$k]['tag'] = Str::truncate(Security::htmlentities( $d['tag'] ), 200);
    }
    
    $view->arr_tag = $arr_tag;
    $view->forum = $arr;
    $view->top = true;
    $view->page = $this->cnt+1;
    $view->u_id = $this->usr_id;
    die($view);
  }
}
