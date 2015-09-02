<?php
class Controller_Niceadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    if ( !is_numeric($_POST['f_id']) ) {
      die(json_encode($res));
    }
    DB::query("UPDATE forum SET nice = nice + 1 WHERE id = ".$_POST['f_id'])->execute(); 
    $res[0] = 1;
    die(json_encode($res));
  }
}
