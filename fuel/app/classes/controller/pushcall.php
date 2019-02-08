<?php
class Controller_Pushcall extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    
    if ($usr_id AND is_numeric($_POST['receiver'])) {
      $query = DB::query("SELECT push_tokens FROM usr where id = ".$_POST['receiver'])->execute()->as_array();
      $tokens = json_decode($query[0]['push_tokens'], true);
      $push_res = [];
      $res[0] = 3;
      if ( isset($tokens[0]) ) {
        foreach ($tokens as $d) {
          $push_res[] = $this->push_call($d,$_POST['myname'],$_POST['room'],$_POST['myphoto']);
        }
        $res[0] = 1;
      }
      $res[1] = $push_res;
    }
    die(json_encode($res));
  }
  public function push_call($token,$name,$room,$photo)
  {
    
    $arr['notification']['title'] = 'calling';
    $arr['notification']['body'] = $name;
    $arr['notification']['icon'] = $photo;
    $arr['notification']['click_action'] = 'https://'.Config::get('my.domain').'/video/?room='.$room;
    $arr['to'] = $token;
    $json = json_encode($arr);

    $ch = curl_init();

    $headers = array(
        'Content-Type: application/json',
        'Authorization: key='.Config::get('my.domain')
    );

    curl_setopt_array($ch, array(
        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $json
    ));
    
    $response = curl_exec($ch);
    
    curl_close($ch);
    
    return $response;
  }
}
