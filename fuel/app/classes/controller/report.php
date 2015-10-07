<?php
class Controller_Report extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      //at first, you must answer
      $res[1] = 'you must answer first';
      die(json_encode($res));
    }
    Model_Csrf::check();
    
    try
    {
      $open_time = date("Y-m-d H:i:s",strtotime("+100 year"));
      $forum = new Model_Forum();
      $forum->parent_id = 0;
      $forum->txt = $_POST['q_id'].' was reported';
      $forum->img = '';
      $forum->usr_id = $usr_id;
      $forum->update_at = date("Y-m-d H:i:s");
      $forum->open_time = $open_time;
      $forum->u_img = '';
      $forum->nice = 0;
      $forum->save();
    }
    catch (Orm\ValidationFailed $e)
    {
      $res[1] = $e->getMessage();
      die(json_encode($res));
    }
    $res[0] = 1;
    die(json_encode($res));
  }
}
