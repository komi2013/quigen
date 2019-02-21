<?php
class Controller_Myprofileshow extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      die(json_encode($res));
    }
    $res['usr_id'] = $usr_id;
    $r = DB::query("select count(*) from follow where receiver = ".$usr_id." AND status = 2")->execute()->as_array();
    $res['follower'] = $r[0]['count'];
    $r = DB::query("select count(*) from follow where sender = ".$usr_id." AND status = 2")->execute()->as_array();
    $res['following'] = $r[0]['count'];
    $r = DB::query("select * from usr where id = ".$usr_id)->execute()->as_array();
    $res['introduce'] = ( isset($r[0]['introduce']) ) ? $r[0]['introduce'] : 'komm';
    $res['myname'] = ( isset($r[0]['name']) ) ? $r[0]['name'] : '';
    $res['nice'] = ( isset($r[0]['nice']) ) ? $r[0]['nice'] : 0;
    $res['certify'] = ( isset($r[0]['certify']) ) ? $r[0]['certify'] : 0;
    $res['amt_quiz'] = ( isset($r[0]['quiz']) ) ? $r[0]['quiz'] : 0;
    $res['amt_forum'] = ( isset($r[0]['forum']) ) ? $r[0]['forum'] : 0;
    $res['provider'] = ( isset($r[0]['provider']) ) ? $r[0]['provider'] : 0;
    
    $r = DB::query("select count(*) as cnt from answer_key_u where usr_id = ".$usr_id)->execute()->as_array();
    $res['amt_answer'] = $r[0]['cnt'];

    $arr_list = [];
    $day = [];
    $msg_usr = [];

    $arr_forum = [];
    $arr = DB::query("select * from forum where usr_id = ".$usr_id." order by open_time desc")->execute()->as_array();
    foreach ($arr as $k => $d) {
      $arr1['forum_id'] = $d['id'];
      $arr1['txt'] = $d['txt'];
      $arr1['img'] = $d['img'];
      $date = new DateTime($d['open_time']);
      $arr1['open_time'] = $date->format('M/jS').' '.$date->format('D');
      $arr1['no_param'] = $d['no_param'];
      $arr_list[$d['open_time']] = $arr1;
    }
//    $arr_forum_comment = [];
//    $arr = DB::query("select * from forum_comment where usr_id = ".$usr_id." order by open_time desc")->execute()->as_array();
//    foreach ($arr as $k => $d) {
//      $arr1['forum_id'] = $d['forum_id'];
//      $arr1['txt'] = $d['txt'];
//      $arr1['img'] = $d['img'];
//      $date = new DateTime($d['open_time']);
//      $arr1['open_time'] = $date->format('M/jS').' '.$date->format('D');
//      $arr1['no_param'] = 0;
//      $arr_list[$d['open_time']] = $arr1;
//    }
    krsort($arr_list);
    $res['list_forum'] = $arr_list;
    $date = new DateTime();
    $i = 0;
    while ($i < 61) {
      $key_day = $date->format('M/jS');
      $arr1['day'] = $key_day.' '.$date->format('D');
      $arr1['answer'] = 0;
      $arr1['spend'] = 0;
      $day[$key_day] = $arr1;
      $date->sub(new DateInterval('P1D'));
      ++$i;
    }
    $sql = "SELECT * FROM answer_by_day WHERE usr_id = "
              .$usr_id." AND day < '".date("Y-m-d H:i:s")."' AND day > '".date("Y-m-d H:i:s",strtotime('-61 day'))."'"
              ." ORDER BY day DESC";
    $arr = DB::query($sql)->execute()->as_array();
    $max = 1;
    foreach ($arr as $k => $d) {
      $date = new DateTime($d['day']);
      $key_day = $date->format('M/jS');
      $day[$key_day]['day'] = $key_day.' '.$date->format('D');
      if ( isset($day[$key_day]['answer']) ) {
        $day[$key_day]['answer'] = $day[$key_day]['answer'] + $d['answer'];
        $day[$key_day]['spend'] = $day[$key_day]['spend'] + $d['spend'];            
      } else {
        $day[$key_day]['answer'] = $d['answer'];
        $day[$key_day]['spend'] = $d['spend'];            
      }
      $day[$key_day]['time'] = Model_Time::s2h($day[$key_day]['spend']);
      if ($day[$key_day]['answer'] > $max) {
        $max = $day[$key_day]['answer'];
      }
    }
    $res['max'] = $max;
    $res['list_graph'] = $day;

    $sql = "SELECT sender, receiver, u_img, txt FROM message WHERE sender = ".$usr_id." OR receiver = ".$usr_id." ORDER BY create_at DESC";
    $arr = DB::query($sql)->execute()->as_array();
    $amt_msg = 0;
    $msg_usr = [];
    foreach ($arr as $d) {
      $usr = 0;
      if ($usr_id != $d['sender']) {
        $usr = $d['sender'];
      }
      if ($usr_id != $d['receiver']) {
        $usr = $d['receiver'];
      }
      if($usr){
        $msg_usr[$usr]['u_img'] = $d['u_img'];
        $msg_usr[$usr]['usr_id'] = $usr;
        if(!isset($msg_usr[$usr]['last_txt'])){
            $msg_usr[$usr]['last_txt'] = Str::truncate($d['txt'],30);
        }
        ++$amt_msg;          
      }
    }
    $res['amt_msg'] = $amt_msg;
    $res['list_msg'] = $msg_usr;
    
    $res[0] = 1;
    die(json_encode($res));
  }
}
