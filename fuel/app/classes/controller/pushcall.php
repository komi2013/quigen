<?php
class Controller_Pushcall extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if ($usr_id AND is_numeric($_POST['receiver'])) {
      $name = strip_tags($_POST['myname']);
      $room = strip_tags($_POST['room']);
      $photo = strip_tags($_POST['myphoto']);
      $receiver = strip_tags($_POST['receiver']);
      $query = DB::query("SELECT * FROM usr where id = ".$receiver." OR id = ".$usr_id )->execute()->as_array();
      $true_call = false;
      $tokens = [];
      foreach ($query as $k => $d) {
          if ($d['id'] == $usr_id AND $d['point'] >= 10) {
              $true_call = true;
          } else  {
              $tokens = json_decode($d['push_tokens'], true);
          }
      }
      if ($true_call) {
        
        $push_res = [];
        $res[0] = 3;

        foreach ($tokens as $d) {
          $push_res[] = $this->push_call($d,$name,$room,$photo,$receiver,$usr_id);
        }
        $res[0] = 1;

        $query = DB::insert('private_news');
        $query->set(array(
          'usr_id' => $receiver,
          'txt' => '<a href="https://'.Config::get('my.domain').'/video/?room='.$room
            .'&receiver='.$receiver.'&sender='.$usr_id.'">'
            . '<img src="'.$photo.'"> '.Config::get('lang.calling').'</a>',
          'create_at' => date("Y-m-d H:i:s"),
        ));
        $query->execute();

        $query = DB::insert('message');
        $query->set(array(
          'sender' => $usr_id,
          'receiver' => $receiver,
          'u_img' => $photo,
          'txt' => Config::get('lang.calling'),
          'create_at' => date("Y-m-d H:i:s"),
        ));
        $query->execute();

        $res[1] = $push_res;
      }
    }
    die(json_encode($res));
  }
  public function push_call($token,$name,$room,$photo,$receiver,$usr_id)
  {
    
    $arr['notification']['title'] = Config::get('lang.calling');
    $arr['notification']['body'] = $name;
    $arr['notification']['icon'] = $photo;
    $arr['notification']['click_action'] = 'https://'.Config::get('my.domain')
            .'/video/?room='.$room
            .'&receiver='.$receiver.'&sender='.$usr_id;
    $arr['to'] = $token;
    $json = json_encode($arr);

    $ch = curl_init();

    $headers = array(
        'Content-Type: application/json',
        'Authorization: key='.Config::get('my.push_key')
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
