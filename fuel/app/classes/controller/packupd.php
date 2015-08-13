<?php
class Controller_PackUpd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      die(json_encode($res));
    }
    if (!is_numeric($_POST['pack_id']))
    {
      die(json_encode($res));
    }
    $query = DB::query("select * from pack where id = ".$_POST['pack_id']." and usr_id = ".$usr_id)
       ->execute()->as_array();
    if(!isset($query[0]['id']))
    {
      die(json_encode($res));
    }
    
    try
    {
      DB::query("update pack set txt = '".$_POST['txt']."' where id = ".$_POST['pack_id'])
       ->execute();
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
