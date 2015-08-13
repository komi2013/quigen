<?php
class Controller_Followingdel extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      die(json_encode($res));
    }
    Model_Csrf::check();
    
    try
    {
      $query = DB::delete('follow')
        ->where('receiver','=',$_POST['receiver'])
        ->and_where('sender','=',$usr_id)->execute();
    }
    catch (Orm\ValidationFailed $e)
    {
      $res[1] = $e->getMessage();
      die(json_encode($res));
    }
    $res[0] = 1;
    Model_Csrf::setcsrf();
    die(json_encode($res));
  }
}
