<?php
class Controller_Paid extends Controller
{
  public function action_index()
  {
    $view = View::forge('paid');

    $res = DB::query("SELECT COUNT(*) FROM pack")
      ->execute()->as_array();
    $cnt = ceil($res[0]['count']/20);
    if (isset($_GET['page']))
    {
      $page = $_GET['page'];
    }
    else
    {
      $page = $cnt;
    }
    $view->page = $page;
    $offset = ($cnt - $page)*20;

    if ($page < 1 OR $offset < 0)
    {
      $view = View::forge('404');
      
      die($view);
    }
    if (isset($_GET['tag']))
    {
      $view->pack = DB::select()->from('pack')
          ->where('txt','=',$_GET['tag'])
          ->and_where('activate','>',0)
          ->order_by('id', 'desc')
          ->execute()->as_array();
    }
    else
    {
      $view->pack = DB::select()->from('pack')
          ->and_where('activate','>',0)
          ->order_by('id', 'desc')
          ->execute()->as_array();
    }
    
    die($view);
  }
}
