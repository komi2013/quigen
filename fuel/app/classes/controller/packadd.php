<?php
class Controller_PackAdd extends Controller
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
    
    try
    {
      $pack = new Model_Pack();
//      $pack_id = $pack->get_new_id();
//      $question = new Model_PayQ();
//      $question->id = $question_id;
      $pack->txt = $_POST['pack_txt'];
      $pack->usr_id = $usr_id;
      $pack->activate =0;
      $pack->update_at = date("Y-m-d H:i:s");
      $pack->save();
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
