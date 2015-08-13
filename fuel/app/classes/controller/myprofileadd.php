<?php
class Controller_Myprofileadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      Model_Log::warn('no usr');
      die(json_encode($res));
    }
    
    try
    {
      $usr = Model_Usr::find('first', array(
        'where' => array(
          array('id', $usr_id),
        ),
      ));
      if (isset($usr->id))
      {
        $usr->id = $usr_id;
        $usr->name = $_POST['myname'];
        $usr->img = $_POST['myphoto'];
        $usr->update_at = date("Y-m-d H:i:s");
        $usr->introduce = $_POST['introduce'];
      	$usr->save();
      }
      else
      {
        $usr = new Model_Usr();
        $usr->id = $usr_id;
        $usr->name = $_POST['myname'];
        $usr->img = $_POST['myphoto'];
        $usr->update_at = date("Y-m-d H:i:s");
        $usr->introduce = $_POST['introduce'];
      	$usr->save();
      }
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
