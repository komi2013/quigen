<?php
class Controller_PackBuy extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    if (!is_numeric($_POST['pack_id']))
    {
      die(json_encode($res));
    }
    $buyer_id = Model_Cookie::get_usr();
    if (!$buyer_id)
    {
      die(json_encode($res));
    }
    try
    {
      $query = DB::query("select point from usr where id = ".$buyer_id)->execute()->as_array();
      $point = $query[0]['point'];
      if ($point < 200)
      {
        $res[0] = 3;
        $res[1] = $point;
        die(json_encode($res));
      }
      $query = DB::query("select usr_id from pack where id = ".$_POST['pack_id'])->execute()->as_array();
      $seller_id = $query[0]['usr_id'];
      DB::start_transaction();
      DB::query("update usr set point = point + 180 where id = ".$seller_id)->execute();
      DB::query("update usr set point = point - 200 where id = ".$buyer_id)->execute();

      DB::query("INSERT INTO lg_pack_tran (seller,pack_id,create_at,buyer) VALUES
        (".$seller_id.",".$_POST['pack_id'].",'".date('Y-m-d H:i:s')."',".$buyer_id.")")->execute();
      DB::query("insert into paid_usr (usr_id,pack_id,create_at) VALUES ("
              .$buyer_id.",".$_POST['pack_id'].",'".date('Y-m-d H:i:s')."')")->execute();
      DB::commit_transaction();
    }
    catch (Orm\ValidationFailed $e)
    {
      DB::rollback_transaction();
      $res[1] = $e->getMessage();
      die(json_encode($res));
    }
    
    $res[0] = 1;
    $res[1] = $point;
    die(json_encode($res));
  }
}
