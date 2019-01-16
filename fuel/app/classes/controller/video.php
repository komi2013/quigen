<?php
class Controller_Video extends Controller
{
  public function action_index()
  {
    $view = View::forge('video');
//    $res = DB::query("select count(*) from question where open_time < '2115-01-01'")
//      ->execute()->as_array();
    die($view);
  }
}
