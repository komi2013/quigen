<?php
class Controller_Myquestionshow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    if (!isset($_GET['endTime']) OR !is_numeric($_GET['endTime'])) {
      Model_Log::warn('no endTime');
      die(json_encode($res));
    }
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      //Model_Log::warn('no usr');
      die(json_encode($res));
    }
    $end_time = date('Y-m-d H:i:s',$_GET['endTime']);
    $query = DB::select()->from('question')
      ->where('usr_id','=',$usr_id)
      ->and_where('create_at','<',$end_time)
      ->order_by('create_at','desc')
      ->limit(100)
      ->execute();
    $i = 0;
    foreach ($query as $k => $d)
    {
      $res[1][$i][0] = $d['id'];
      $res[1][$i][1] = Str::truncate(Security::htmlentities($d['txt']), 40);
      $res[1][$i][2] = $d['img'];
      $res[1][$i][3] = '';
      $open_time = new DateTime($d['create_at']);
      $res[1][$i][4] = $open_time->getTimestamp();
      $res[0] = 1;
      ++$i;
    }
    die(json_encode($res));    
  }
}
