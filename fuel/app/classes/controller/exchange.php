<?php
class Controller_Exchange extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      $res[1] = 'you must answer first';
      die(json_encode($res));
    }
    if ($_POST['unit'] != 2 AND $_POST['unit'] != 4 AND $_POST['unit'] != 6 AND $_POST['unit'] != 8 AND $_POST['unit'] != 10)
    {
      $res[1] = 'not correct post';
      die(json_encode($res));
    }
    $post_point = $_POST['unit'] * 10000; 
    $query = DB::query("select * from usr where id = ".$usr_id)
       ->execute()->as_array();
    if($query[0]['point'] < $post_point)
    {
      $res[1] = 'post point is too much';
      die(json_encode($res));
    }
    Model_Csrf::check();
    $fee = 1000;
    $send_yen = $post_point /2 - $fee; 
    try
    {
      DB::start_transaction();
      DB::query("update usr set point = point - ".$post_point." where id = ".$usr_id)->execute();
      $send_money = new Model_SendMoney();
      $send_money->email = $_POST['email'];
      $send_money->usr_id = $usr_id;
      $send_money->yen = $send_yen;
      $send_money->bank_info = $_POST['bank_info'];
      $send_money->create_at = date("Y-m-d H:i:s");
      $send_money->save();
      DB::commit_transaction();
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
