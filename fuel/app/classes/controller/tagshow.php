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
    
    $arr_tag = array();
    foreach ($query as $k => $d)
    {
      $arr_tag[$k][] = $d['txt'];
    }
    
    if ( isset($query[0]['txt']) ) {
      $arr_prev = DB::select()->from('tag')
        ->where('open_time','<',$query[0]['open_time'])
        ->and_where('txt','=',$arr_tag[0])
        ->order_by('open_time', 'desc')->limit(1)
        ->execute()->as_array();
      $arr_next = DB::select()->from('tag')
        ->where('open_time','>',$query[0]['open_time'])
        ->and_where('txt','=',$arr_tag[0])
        ->order_by('open_time', 'asc')->limit(1)
        ->execute()->as_array();
    }

    $res[0] = 1;
    $res[1] = $arr_tag;
    
    if ( isset($arr_prev[0]['question_id']) ) {
      $res[2][0] = $arr_prev[0]['question_id'];
    } else {
      $res[2][0] = '';
    }
    if ( isset($arr_next[0]['question_id']) ) {
      $res[2][1] = $arr_next[0]['question_id'];
    } else {
      $res[2][1] = '';
    }
    die(json_encode($res));    
  }
}
