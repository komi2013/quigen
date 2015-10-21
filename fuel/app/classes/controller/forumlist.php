<?php
class Controller_Forumlist extends Controller
{
  public function action_index()
  {
    $view = View::forge('forum_list');
    $res = DB::query("select count(*) from forum where open_time < '".date('Y-m-d H:i:s')."'" )
      ->execute()->as_array();
    $this->cnt = ceil($res[0]['count']/20);
    $this->usr_id = Model_Cookie::get_usr();
    if (isset($_GET['page']))
    {
      $page = $_GET['page'];
      $view->page = $page;
      $offset = ($this->cnt - $page)*20;
      if ($page > 1 && $offset > -1)
      {
        $forum = [];
        $forum = DB::select()->from('forum')
          ->where('open_time','<',date('Y-m-d H:i:s'))
          ->and_where('parent_id','=',0)
          ->order_by('open_time', 'desc')
          ->limit(20)->offset($offset)
          ->execute()->as_array();
        $view->forum = $forum;
        $view->u_id = $this->usr_id;
        die($view);
      }
      else
      {
        $this->top_forum();
      }
    }
    else
    {
      $this->top_forum();
    }
  }
  public function top_forum()
  {
    $view = View::forge('forum_list');
    $forum = DB::select()->from('forum')
      ->where('open_time','<',date('Y-m-d H:i:s'))
      ->and_where('parent_id','=',0)
      ->order_by('open_time', 'desc')
      ->limit(20)
      ->execute()->as_array();
    $view->forum = $forum;
    $view->top = true;
    $view->page = $this->cnt+1;
    $view->u_id = $this->usr_id;
    die($view);
  }
}
