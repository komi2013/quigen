<?php
class Controller_Payquizusrshow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    if( !isset($_GET['q']) ) die(json_encode($res));
    $pay_q = DB::select()->from('pay_q')
      ->where('id','=',$_GET['q'])
      ->execute()->as_array();
    
    $generator_id = $_GET['u'];  
    $usr_id = Model_Cookie::get_usr();
    $correct = DB::select()->from('pay_correct')
      ->where('pay_q_id','=',$_GET['q'])
      ->order_by('id', 'desc')
      ->execute()
      ->as_array();
    $incorrect = DB::select()->from('pay_incorrect')
      ->where('pay_q_id','=',$_GET['q'])
      ->order_by('id', 'desc')
      ->execute()
      ->as_array();
    $arr_usr = array();
    $arr_usr[] = $generator_id;
    $ass_correct_usr = array();
    foreach ($correct as $d)
    {
      $arr_usr[] = $d['usr_id'];
      $ass_correct_usr[$d['usr_id']]['usr_id'] = $d['usr_id'];
      $ass_correct_usr[$d['usr_id']]['id'] = $d['id']; // answer number
    }
    $ass_incorrect_usr = array();
    foreach ($incorrect as $d)
    {
      $arr_usr[] = $d['usr_id'];
      $ass_incorrect_usr[$d['usr_id']]['usr_id'] = $d['usr_id'];
      $ass_incorrect_usr[$d['usr_id']]['id'] = $d['id'];
    }
    
    $usr = DB::select()->from('usr')
      ->where('id','in',$arr_usr)
      ->execute()->as_array();
    $generator = array();

    $ass_usr = array();
    foreach ($usr as $k => $d)
    {
      if ($d['id'] == $generator_id)
      {
        $generator[0] = $d['id'];
        $generator[1] = $d['name'];
        $generator[2] = $d['img'];
      }
      $ass_usr[$d['id']][0] = $d['id'];
      $ass_usr[$d['id']][1] = Security::htmlentities($d['name']);
      $ass_usr[$d['id']][2] = $d['img'];
    }
    if(!isset($generator[0]))
    {
      $generator[0] = $generator_id;
      $generator[1] = 'guest';
      $generator[2] = '/assets/img/icon/guest.png';
      
    }
    $correct_i = 0;
    $arr_correct = array();
    $correct_key = array();
    foreach ($ass_correct_usr as $k => $d)
    {
      if (isset($ass_usr[$k]))
      {
        $arr_correct[$correct_i][0] = $ass_usr[$k][0];
        $arr_correct[$correct_i][1] = Security::htmlentities($ass_usr[$k][1]);
        $arr_correct[$correct_i][2] = $ass_usr[$k][2];
      }
      else
      {
        $arr_correct[$correct_i][0] = $d['usr_id'];
        $arr_correct[$correct_i][1] = 'guest';
        $arr_correct[$correct_i][2] = '/assets/img/icon/guest.png';
      }
      $arr_correct[$correct_i][3] = $d['id'];
      $correct_key[$correct_i] = $d['id']; 
      ++$correct_i;
    }
    
    $incorrect_i = 0;
    $arr_incorrect = array();
    $incorrect_key = array();
    foreach ($ass_incorrect_usr as $k => $d)
    {
      if (isset($ass_usr[$k]))
      {
        $arr_incorrect[$incorrect_i][0] = $ass_usr[$k][0];
        $arr_incorrect[$incorrect_i][1] = Security::htmlentities($ass_usr[$k][1]);
        $arr_incorrect[$incorrect_i][2] = $ass_usr[$k][2];
      }
      else
      {
        $arr_incorrect[$incorrect_i][0] = $d['usr_id'];
        $arr_incorrect[$incorrect_i][1] = 'guest';
        $arr_incorrect[$incorrect_i][2] = '/assets/img/icon/guest.png';
      }
      $arr_incorrect[$incorrect_i][3] = $d['id'];
      $incorrect_key[$incorrect_i] = $d['id']; 
      ++$incorrect_i;
    }

    $res[0] = 1;
    $res[1] = $generator;
    $res[2] = $arr_correct;
    $res[3] = $arr_incorrect;
    die(json_encode($res));
    
// 		return Response::forge(View::forge('welcome/index'));
  }
}
