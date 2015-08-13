<?php
class Controller_Followdo extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    if ( !isset($_POST['arr_u'][0]) ) {
      Model_Log::warn('no arr_u');
      die(json_encode($res));
    }
    $usr_id = Model_Cookie::get_usr();
    try {
    
      if ($_POST['who'] == 'follower' AND $_POST['do'] == 'delete') {
        DB::delete('follow')
          ->where('sender','in',$_POST['arr_u'])
          ->and_where('receiver','=',$usr_id)
          ->execute();
      }
      if ($_POST['who'] == 'follower' AND $_POST['do'] == 'confirm') {
        DB::update('follow')->value('status',2)
          ->where('sender','in',$_POST['arr_u'])
          ->and_where('receiver','=',$usr_id)
          ->execute();
      }
      if ($_POST['who'] == 'following' AND $_POST['do'] == 'delete') {
        DB::delete('follow')
          ->where('receiver','in',$_POST['arr_u'])
          ->and_where('sender','=',$usr_id)
          ->execute();
      }

    } catch (Orm\ValidationFailed $e) {
      $res[1] = $e->getMessage();
      Model_Log::warn('orm err');
      die(json_encode($res));
    }

    $res[0] = 1;
    die(json_encode($res));
  }
}
