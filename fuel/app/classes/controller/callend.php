<?php
class Controller_Callend extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
        die(json_encode($res));
    }
    if ( Session::get('start') AND Session::get('sender') ) {
        $minutes = floor( (time() - Session::get('start')) / 60 );
        $point = $minutes * 5;
        DB::query("UPDATE usr SET point = point - ".$point." WHERE id = ".Session::get('sender'))->execute();
        DB::query("UPDATE usr SET point = point + ".$point." WHERE id = ".$usr_id)->execute();
        Session::delete('sender');
        Session::delete('start');
        $res[0] = 1;
    }
    die(json_encode($res));
  }
}
