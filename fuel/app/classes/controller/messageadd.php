<?php
class Controller_Messageadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      Model_Log::warn('no usr');
      die(json_encode($res));
    }
    $open_time = date("Y-m-d H:i:s");
    $query = DB::select()->from('mt_block_generate')
      ->where('usr_id','=',$usr_id)
      ->execute()->as_array();
    if ( isset($query[0]) ) {
      Model_Log::warn('blocked');
      die( json_encode($res) );
    }
     $query = DB::query("select nextval('message_id_seq')")->execute();
     foreach ($query as $d) {
       $message_id = $d['nextval'];
     }
    if ($_POST["img"] == 'no') {
      $web_path = '';
    } else {
      @mkdir(DOCROOT.'assets/img/message/'.date('Ymd'), 0777);
      @chmod(DOCROOT.'assets/img/message/'.date('Ymd'), 0777);
      $img_path = DOCROOT.'assets/img/message/'.date('Ymd').'/'.$message_id.'.png';
      $web_path = '/assets/img/message/'.date('Ymd').'/'.$message_id.'.png';
      $canvas = $_POST["img"];
      $canvas = preg_replace("/data:[^,]+,/i","",$canvas);
      $canvas = base64_decode($canvas);
      $image = imagecreatefromstring($canvas);
      imagesavealpha($image, TRUE);
      imagepng($image ,$img_path);
    }
    $txt = htmlspecialchars($_POST['txt'], ENT_QUOTES);
    $arr = Model_Emoji::$table;
    $arr['&lt;br&gt;'] = '<br>';
    $arr['&amp;nbsp;'] = ' ';
    $search = array_keys($arr);
    $replace = array_values($arr);
    $txt = str_replace($search,$replace,$txt);
    
    try {
      $query = DB::insert('message');
      $query->set(array(
        'id' => $message_id,
        'txt' => $txt,
        'img' => $web_path,
        'sender' => $usr_id,
        'create_at' => date("Y-m-d H:i:s"),
        'u_img' => $_POST['myphoto'],
        'receiver' => $_POST['receiver'],
      ));
      $query->execute();
      //DB::query("UPDATE usr SET message = message + 1 WHERE id = ".$usr_id)->execute();
    } catch (Exception $e) {
      $res[1] = $e->getMessage();
      Model_Log::warn($res[1]);
      die(json_encode($res));
    }
    $res[0] = 1;
    //$res[1] = isset( $_POST['f_id'] ) ? $_POST['f_id'] : $message_id;
    die(json_encode($res));
  }
}
