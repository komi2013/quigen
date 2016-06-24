<?php
class Controller_Uquestionshow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    if (!isset($_GET['usr']) OR !is_numeric($_GET['usr'])) {
      Model_Log::warn('no usr');
      die(json_encode($res));
    }

    $end_time = date('Y-m-d H:i:s',$_GET['endTime']);
    if ( $_GET['list'] == 'answer' ) {
      $arr_answer_key_u = DB::select()->from('answer_key_u')
        ->where('usr_id','=',$_GET['usr'])
        ->and_where('create_at','<',$end_time)
        ->order_by('create_at','desc')
        ->limit(100)
        ->execute()->as_array();
      $i = 0;
      foreach ($arr_answer_key_u as $k => $d) {
        $res[0] = 1;
        $res[1][$i][0] = $d['question_id'];
        $res[1][$i][1] = Str::truncate(Security::htmlentities($d['q_txt']), 40);
        $res[1][$i][2] = $d['q_img'];
        $res[1][$i][3] = $d['quiz_num'];
        $create_at = new DateTime($d['create_at']);
        $res[1][$i][4] = $create_at->getTimestamp();
        $res[1][$i][5] = $d['result'];
        ++$i;
      }
      
    } else {
      $query = DB::select()->from('question')
        ->where('usr_id','=',$_GET['usr'])
        ->and_where('open_time','<',$end_time)
        ->order_by('open_time','desc')
        ->limit(100)
        ->execute();

      $i = 0;
      foreach ($query as $k => $d)
      {
        $res[1][$i][0] = $d['id'];
        $txt = Security::htmlentities($d['txt']);
        $res[1][$i][1] = Str::truncate(Security::htmlentities($d['txt']), 40);
        $res[1][$i][2] = $img = Security::htmlentities($d['img']);
        $res[1][$i][3] = '';
        $open_time = new DateTime($d['open_time']);
        $res[1][$i][4] = $open_time->getTimestamp();
        $res[0] = 1;
        ++$i;
      }
      
    }
    die(json_encode($res));    
  }
}
