<?php
class Controller_Pushadd extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if ($usr_id) {
      $query = DB::query("SELECT push_tokens FROM usr where id = ".$usr_id)->execute()->as_array();
      $tokens = json_decode($query[0]['push_tokens'], true);
      $tokens = isset($tokens[0]) ? $tokens : [];
//      var_dump($tokens);
//      $tokens = $tokens + [$_POST['token']];
      $tokens = array_merge($tokens, [$_POST['token']]);
//      var_dump($tokens);
      $tokens = array_unique($tokens);
      $tokens = json_encode($tokens);
//      var_dump($tokens);
      DB::update('usr')->value('push_tokens', $tokens)->where('id', $usr_id)->execute();
      $res[0] = 1;
    }
    die(json_encode($res));  
  }
}
