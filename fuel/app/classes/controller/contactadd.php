<?php
class Controller_Contactadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      Model_Log::warn('no usr');
      $res[1] = 'you must answer first';
      die(json_encode($res));
    }
    Model_Csrf::check();
    try
    {
      $contact = new Model_Contact();
      $contact->txt = $_POST['contact'];
      $contact->usr_id = $usr_id;
      $contact->create_at = date('Y-m-d H:i:s');
    	$contact->save();
    }
    catch (Orm\ValidationFailed $e)
    {
      $res[1] = $e->getMessage();
      Model_Log::warn('orm err');
      die(json_encode($res));
    }
    $res[0] = 1;
    die(json_encode($res));
  }
}
