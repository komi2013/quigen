<?php
class Controller_Searchshow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    if (!isset($_GET['tag']))
    {
      Model_Log::warn('no tag');
      die(json_encode($res));
    }
    // tag should be filtered by time
    $query = DB::select()->from('tag')
      ->where('txt','=',$_GET['tag'])
      ->execute()->as_array();
    $arr_qu_id = array(0);
    $cnt = 0;
    foreach ($query as $d)
    {
      $arr_qu_id[] = $d['question_id'];
      ++$cnt;
    }
    $end_time = date('Y-m-d H:i:s',$_GET['endTime']);
    $query = DB::select()->from('question')
      ->where('id','in',$arr_qu_id)
      ->and_where('open_time','<',$end_time)
      ->order_by('open_time','desc')
      ->limit(100)
      ->execute();
    $i = 0;
    foreach ($query as $k => $d)
    {
      $res[1][$i][0] = $d['id'];
      $res[1][$i][1] = Str::truncate(Security::htmlentities($d['txt']), 30);
      $res[1][$i][2] = $d['img'];
      $json_arr_q_data = json_encode(array($d['id'],$d['txt'],$d['img'],$d['usr_id']));
      $q_data = Crypt::encode($json_arr_q_data,Config::get('crypt_key.q_data'));
      $res[1][$i][3] = $q_data;
      $open_time = new DateTime($d['open_time']);
      $res[1][$i][4] = $open_time->getTimestamp();
      $res[0] = 1;
      ++$i;
    }
    $res[2] = $cnt;
    die(json_encode($res));    
  }
}
