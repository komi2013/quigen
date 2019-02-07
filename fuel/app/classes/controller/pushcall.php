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
          $push_res[] = $this->push_call($d);
        }
        $res[0] = 1;
      }
      $res[1] = $push_res;
    }
    die(json_encode($res));  
  }
  public function push_call($token)
  {
    
    $arr['notification']['title'] = '本当ですか？';
    $arr['notification']['body'] = '本文が入ります';
    $arr['notification']['icon'] = 'https://zstg-english.quigen.info/apple-touch-icon-precomposed.png';
    $arr['notification']['click_action'] = 'https://zstg-english.quigen.info/';
    $arr['to'] = $token;
    $json = json_encode($arr);

    $ch = curl_init();

    $headers = array(
        'Content-Type: application/json',
        'Authorization: key=AAAAQ4U9QiY:APA91bGSYhGZD4z_gOhkx5wdbVrRmhHt_6ETd7Vb4nm_mN0-fkTeiIHknXdKtiD2XZXbjX2AiDhjwYK3ScJTlZtyCXr2tA0tmlV3ebl2yk3LlUbgCQaaQnU-9BRY3JVfy4DhpHqkKCuY'
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
