<?php
class Controller_Forumparamadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    //Model_Csrf::check();
    if ( !isset($_POST['f_id']) OR !is_numeric($_POST['f_id']) ) {
      die(json_encode($res));
    }
    if ( !isset($_POST['param']) ) {
      die(json_encode($res));
    }
    if ( $_POST['param'] != 'nice' AND $_POST['param'] != 'certify' ) {
      die(json_encode($res));
    }
    if ( !isset($_POST['table']) ) {
      die(json_encode($res));
    }
    if ( $_POST['table'] != 'forum' AND $_POST['table'] != 'forum_comment' ) {
      die(json_encode($res));
    }
    if ( !isset($_POST['u_id']) OR !is_numeric($_POST['u_id']) ) {
      die(json_encode($res));
    }
    DB::query("UPDATE ".$_POST['table']." SET ".$_POST['param']." = ".$_POST['param']." + 1 WHERE id = ".$_POST['f_id'])->execute();
    $usr_id = Model_Cookie::get_usr();
    $sql = "INSERT INTO lg_".$_POST['table']."_param (param,usr_id,".$_POST['table']."_id) VALUES ('".$_POST['param']."',".$usr_id.",".$_POST['f_id'].")";
    DB::query($sql)->execute();
    DB::query("UPDATE usr SET ".$_POST['param']." = ".$_POST['param']." + 1 WHERE id = ".$_POST['u_id'])->execute();
    $res[0] = 1;
    die(json_encode($res));
  }
}
