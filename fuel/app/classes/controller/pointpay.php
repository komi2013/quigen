<?php
class Controller_PointPay extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      die(json_encode($res));
    }
    try
    {
      $pay = $_POST['pay'];
      $query = DB::query("select point from usr where id = ".$usr_id)->execute()->as_array();
      if( !isset($query[0]['point']) ) {
        die(json_encode($res));
      }
      $point = $query[0]['point'];
      if ($point < $pay) {
        $res[0] = 3;
        $res[1] = $point;
        die(json_encode($res));
      }
      DB::start_transaction();
      DB::query("update usr set point = point - ".$pay." where id = ".$usr_id)->execute();
      $lg_point_tran = new Model_LgPointTran();
      $lg_point_tran->usr_id = $usr_id;
      $lg_point_tran->point = $pay;
      $lg_point_tran->txt = $_POST['type'];
      $lg_point_tran->create_at = date( "Y-m-d H:i:s" );
      $lg_point_tran->save();
      $point = $point - $pay;
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
