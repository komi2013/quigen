<?php
class Controller_Followshow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    if( !isset($_GET['endTime']) ) die( json_encode($res) );
    $usr_id = Model_Cookie::get_usr();
    $end_time = date('Y-m-d H:i:s',$_GET['endTime']);
    
    $query = DB::select()->from('follow')
      ->where('sender','=',$usr_id)
      ->and_where('status','=',2)
      ->execute()->as_array();
    $arr_receiver = [];
    foreach ($query as $d) {
      $arr_receiver[] = $d['receiver'];
    }
    if ( !isset($arr_receiver[0]) ) {
      $res[1] = 'no record';
      die(json_encode($res)); 
    }
    $query = DB::select()->from('question')
      ->where('usr_id','in',$arr_receiver)
      ->and_where('open_time','<',$end_time)
      ->order_by('open_time','desc')
      ->limit(100)
      ->execute();
    $i = 0;
    foreach ($query as $k => $d)
    {
      $res[1][$i][0] = $d['id'];
      $res[1][$i][1] = Str::truncate(Security::htmlentities($d['txt']), 40);
      $res[1][$i][2] = $d['img'];
      $res[1][$i][3] = '';
      $open_time = new DateTime($d['open_time']);
      $res[1][$i][4] = $open_time->getTimestamp();
      $res[0] = 1;
      ++$i;
    }
    die(json_encode($res));    
  }
}
