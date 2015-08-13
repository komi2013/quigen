<?php
class Controller_Commentshow extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    if (!isset($_GET['q']) OR !is_numeric($_GET['q'])) {
      Model_Log::warn('no q');
      die(json_encode($res));
    }
    if (isset($_GET['pay'])) {
      $query = DB::select()->from('pay_comment')
        ->where('pay_q_id','=',$_GET['q'])
        ->order_by('create_at', 'desc')      
        ->execute()->as_array();
    } else {
      $query = DB::select()->from('comment')
        ->where('question_id','=',$_GET['q'])
        ->order_by('create_at', 'desc')      
        ->execute()->as_array();
    }
    if (!isset($query[0]['id'])) {
      //Model_Log::warn('no comment record');
      die(json_encode($res));
    }

    $arr_u_id = array();
    foreach ($query as $k => $d) {
      $arr_u_id[] = $d['usr_id'];
      $res[1][$k][0] = $d['usr_id'];
      $res[1][$k][1] = Security::htmlentities($d['txt']);
      $res[1][$k][2] = '';
    }
    
    $query = DB::select()->from('usr')
      ->where('id','in',$arr_u_id)
      ->execute()->as_array();
    foreach ($res[1] as $k => $d) {
      foreach ($query as $dd)
      {
        if ($d[0] == $dd['id']) {
          $res[1][$k][2] = Security::htmlentities($dd['img']);
        }
      }
      $res[0] = 1;
    }
    
    die(json_encode($res));
  }
}
