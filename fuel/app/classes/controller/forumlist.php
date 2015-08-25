<?php
class Controller_Forumlist extends Controller
{
  public function action_index()
  {
    $view = View::forge('top');
    $res = DB::query("select count(*) from forum where open_time < '2115-01-01'")
      ->execute()->as_array();
    $this->cnt = ceil($res[0]['count']/20);
    if (isset($_GET['page']))
    {
      $page = $_GET['page'];
      $view->page = $page;
      $offset = ($this->cnt - $page)*20;
      if ($page > 1 && $offset > -1)
      {
        $forum = DB::select()->from('forum')
          ->where('open_time','<',date('Y-m-d H:i:s'))
          ->order_by('open_time', 'desc')
          ->limit(20)->offset($offset)
          ->execute()->as_array();
        foreach ($forum as $d)
        {
          $arr[$d['id']]['id'] = $d['id'];
          $arr[$d['id']]['content'] = $d['content'];
          $arr[$d['id']]['img_txt'] = $d['img_txt'];
        }
        $view->forum = $arr;
        
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
    $forum = DB::select()->from('forum')
      ->where('open_time','<',date('Y-m-d H:i:s'))
      ->order_by('open_time', 'desc')
      ->limit(20)
      ->execute()->as_array();
    foreach ($forum as $d)
    {
      $arr[$d['id']]['id'] = $d['id'];
      $arr[$d['id']]['content'] = $d['content'];
      $arr[$d['id']]['img_txt'] = $d['img_txt'];
    }
    $view->forum = $arr;

    die($view);
  }
}
