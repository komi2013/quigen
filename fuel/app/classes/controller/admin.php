<?php
class Controller_Admin extends Controller
{
  public function action_index()
  {
    $usr_id = Model_Cookie::get_usr();
    $auth = false;
    foreach (Config::get('my.adm') as $d)
    {
      if ($d == $usr_id)
      {
        $auth = true;
      }
    }
    if (!$auth)
    {
      $view = View::forge('404');
      
      die($view);
    }
    
    Model_Csrf::setcsrf();
    $view = View::forge('admin');
    
    $view->page = 0;
    if ( isset($_GET['q']) ) {
      $res = DB::query("select count(*) from question")->execute()->as_array();
      $cnt = ceil(($res[0]['count'])/100);
      if (isset($_GET['page']))
      {
        $page = $_GET['page'];
      }
      else
      {
        $page = $cnt;
      }
      $view->page = $page;
      $offset = ($cnt - $page)*100;
      if ($page > 0 && $offset > -1)
      {
        $view->question = DB::select()->from('question')
          ->order_by('id', 'desc')->limit(100)->offset($offset)
          ->execute()->as_array();
      }
    }
    
    if ( isset($_GET['u']) ) {
      $res = DB::query("select count(*) from usr")->execute()->as_array();
      $cnt = ceil(($res[0]['count'])/100);
      if (isset($_GET['page']))
      {
        $page = $_GET['page'];
      }
      else
      {
        $page = $cnt;
      }
      $view->page = $page;
      $offset = ($cnt - $page)*100;
      if ($page > 0 && $offset > -1)
      {
        $view->usr = DB::select()->from('usr')
          ->order_by('id', 'desc')->limit(100)->offset($offset)
          ->execute()->as_array();
      }
    }
    
    if ( isset($_GET['cont']) ) {
      $res = DB::query("select count(*) from contact")->execute()->as_array();
      $cnt = ceil(($res[0]['count'])/100);
      if (isset($_GET['page']))
      {
        $page = $_GET['page'];
      }
      else
      {
        $page = $cnt;
      }
      $view->page = $page;
      $offset = ($cnt - $page)*100;
      if ($page > 0 && $offset > -1)
      {
        $view->comment = DB::select()->from('contact')
          ->order_by('id', 'desc')->limit(100)->offset($offset)
          ->execute()->as_array();
      }
    }
    
    if ( isset($_GET['com']) ) {
      $res = DB::query("select count(*) from comment")->execute()->as_array();
      $cnt = ceil(($res[0]['count'])/100);
      if (isset($_GET['page']))
      {
        $page = $_GET['page'];
      }
      else
      {
        $page = $cnt;
      }
      $view->page = $page;
      $offset = ($cnt - $page)*100;
      if ($page > 0 && $offset > -1)
      {
       
        $view->comment = DB::select()->from('comment')
          ->order_by('id', 'desc')->limit(100)->offset($offset)
          ->execute()->as_array();
      }
    }
    die($view);
  }
}
