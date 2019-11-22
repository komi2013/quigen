<?php
class Controller_Tagshow extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    if( !isset($_GET['q']) ) {
      Model_Log::warn('no q');
      die(json_encode($res));  
    }       
    if ($_GET['q'] == 'tag') {
      $arr_answer = DB::query(" SELECT txt FROM tag GROUP BY txt")->execute()->as_array();
      $res[0] = 1;
      $i = 0;
      foreach ($arr_answer as $d) {
        $res[1][$i] = $d['txt'];
        ++$i;
      }
      die(json_encode($res));
    } else if( !is_numeric($_GET['q']) ) {
      Model_Log::warn('q is not numeric');
      die(json_encode($res));  
    }
      

    
    $query = DB::select()->from('tag')
      ->where('question_id','=',$_GET['q'])
      ->execute()->as_array();
    
    $arr_tag = [];
    foreach ($query as $k => $d) {
      $arr_tag[$k]['txt'] = $d['txt'];
      $arr_tag[$k]['quiz_num'] = $d['quiz_num'];
      $arr_tag[$k]['open_time'] = $d['open_time'];
    }
    
    if ( isset($arr_tag[0]['txt']) ) {
      $arr_prev = DB::select()->from('tag')
        ->where('open_time','<',$arr_tag[0]['open_time'])
        ->and_where('txt','=',$arr_tag[0]['txt'])
        ->order_by('open_time', 'desc')->limit(1)
        ->execute()->as_array();
      $arr_next = DB::select()->from('tag')
        ->where('open_time','>',$arr_tag[0]['open_time'])
        ->and_where('txt','=',$arr_tag[0]['txt'])
        ->order_by('open_time', 'asc')->limit(1)
        ->execute()->as_array();
    }

    $res[0] = 1;
    $res[1] = $arr_tag;
    $prev = 0;
    $prev_q_num = 0;
    if ( isset($arr_prev[0]['question_id']) ) {
      $prev = $arr_prev[0]['question_id'];
      $prev_q_num = $arr_prev[0]['quiz_num'];
    }
    $next = 0;
    $next_q_num = 0;
    if ( isset($arr_next[0]['question_id']) ) {
      $next = $arr_next[0]['question_id'];
      $next_q_num = $arr_next[0]['quiz_num'];
    } else {
      $arr_next = DB::select()->from('tag')
        ->where('txt','=',$arr_tag[0]['txt'])
        ->and_where('quiz_num','=',1)
        ->limit(1)
        ->execute()->as_array();
      $next = $arr_next[0]['question_id'];
      $next_q_num = $arr_next[0]['quiz_num'];
    }
    $arr = DB::query(
      "SELECT * FROM question WHERE id IN (".$prev.",".$next.") ORDER BY open_time ASC "
      )->execute()->as_array();
    
    foreach ($arr as $k => $d) {
      if ($prev == $d['id']) {
        $res[2][0] = $d['id'];
        $res[2][1] = Str::truncate(Security::htmlentities($d['txt']), 40);
        $res[2][2] = $d['img'];
        $res[2][3] = $prev_q_num;
      } else {
        $res[3][0] = $d['id'];
        $res[3][1] = Str::truncate(Security::htmlentities($d['txt']), 40);
        $res[3][2] = $d['img'];
        $res[3][3] = $next_q_num;
      }
    }
    if ( isset($_GET['callback']) ) {
      header("Content-Type: application/javascript; charset=utf-8");
      die( 'jsonp('.json_encode($res).')' );
    } else {
      header("Content-Type: application/json; charset=utf-8");
      die( json_encode($res) );
    }
       
  }
}
