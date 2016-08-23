<?php
class Controller_Answerbydayadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      $res[1] = 'you must answer first';
      die(json_encode($res));
    }
    $day_sum = json_decode($_POST['day_sum'],true);
    $i = 0;
    foreach ($day_sum as $k => $d) {
      if ( is_numeric($d[0]) AND is_numeric($d[1]) ) {
        $unix = $k * 24 * 60 * 60;
        if ($i < 1) {
          $sql = "INSERT INTO answer_by_day (usr_id, day, answer, spend, update_at) 
                    VALUES (".$usr_id.", '".date('Y-m-d H:i:s',$unix)."', ".$d[0].", ".$d[1].", '".date('Y-m-d H:i:s')."') ";
        } else {
          $sql .= ",(".$usr_id.", '".date('Y-m-d H:i:s',$unix)."', ".$d[0].", ".$d[1].", '".date('Y-m-d H:i:s')."')"; 
        }
        ++$i;
      }
    }
    if ($i) {
      DB::query($sql)->execute();
    }
    $res[0] = 1;
    die(json_encode($res));
  }
}
