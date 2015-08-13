<?php
class Controller_MypackLIst extends Controller
{
  public function action_index()
  {
    $view = View::forge('mypack_list');
    $usr_id = Model_Cookie::get_usr();
    if ($usr_id)
    {
      $res = DB::query("select count(*) from pack where usr_id = ".$usr_id)
        ->execute()->as_array();
      $view->follower = $res[0]['count'];
    }
    Model_Csrf::setcsrf();
    
    $view->u_id = $usr_id;
    die($view);
  }
}
