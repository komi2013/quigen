<?php
class Controller_Packqushow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    $query = DB::select()->from('paid_usr')
      ->where('usr_id','=',$usr_id)
      ->and_where('pack_id','=',$_GET['p'])
      ->execute()->as_array();
    if (!isset($query[0]['id']))
    {
      die(json_encode($res));
    }

    if ($_GET['endNum'] > 0)
    {
      $query = DB::select()->from('pay_q')
        ->where('pack_id','=',$_GET['p'])
        ->and_where('id','<',$_GET['endNum'])
        ->order_by('id','asc')
//         ->limit(100)
        ->execute();
    }
    else
    {
      $query = DB::select()->from('pay_q')
        ->where('pack_id','=',$_GET['p'])
        ->order_by('id','asc')
        ->execute();
    }
    $arr_q_id = array();
    foreach ($query as $k => $d)
    {
      $arr_q_id[] = $d['id'];
    }

    $correct = DB::select()->from('pay_correct')
      ->where('usr_id','=',$usr_id)
      ->and_where('pay_q_id','in',$arr_q_id)
      ->order_by('id','asc')
      ->execute()->as_array();
    $arr_res = array();
    foreach ($correct as $d) {
      $arr_res[$d['pay_q_id']]['res'] = 1;
    }
    $incorrect = DB::select()->from('pay_incorrect')
      ->where('usr_id','=',$usr_id)
      ->and_where('pay_q_id','in',$arr_q_id)
      ->order_by('id','asc')
      ->execute()->as_array();
    foreach ($incorrect as $d) {
      $arr_res[$d['pay_q_id']]['res'] = 2;
    }
    $i = 0;
    foreach ($query as $k => $d)
    {
      $res[1][$i][0] = $d['id'];
      $res[1][$i][1] = Str::truncate(Security::htmlentities($d['txt']), 40);
      $res[1][$i][2] = $d['img'];
      $status = 0; //0=not yet,1=correct, 2=incorrect
      if (isset($arr_res[$d['id']]['res'])) {
        $status = $arr_res[$d['id']]['res'];
      }
      $res[1][$i][3] = '';
      $res[1][$i][4] = $status;
      $res[0] = 1;
      ++$i;
    }
    die(json_encode($res));    
  }
}
