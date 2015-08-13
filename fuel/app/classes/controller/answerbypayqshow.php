<?php
class Controller_Answerbypayqshow extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    if(!isset($_GET['q']) OR !is_numeric($_GET['q'])) {
      Model_Log::warn('no q');
      die(json_encode($res)); 
    }
    $query = DB::select()->from('answer_by_pay_q')
      ->where('pay_q_id','=',$_GET['q'])
      ->execute();
    
    if ($query[0]['pay_q_id'])
    {
      $res[1][0] = $query[0]['correct'];
      $res[1][1] = $query[0]['amount'];
    }
    else
    {
      $res[1][0] = 0;
      $res[1][1] = 0;
    }
    
    $res[0] = 1;
    die(json_encode($res));    
  }
}
