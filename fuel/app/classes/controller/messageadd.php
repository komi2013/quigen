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
    $query = DB::select()->from('message')
            ->where('create_at','>',date("Y-m-d H:i:s", strtotime("-20 hours")))
            ->execute()->as_array();
    $already = false;
    foreach ($query as $d) {
        if ($d['sender'] == $usr_id) {
            $already = true;
        }
    }
    $query = DB::select()->from('usr')->where('id','=',$usr_id)->execute()->as_array();
    if ( isset($query[0]['id']) ) {
      if ($query[0]['point'] < 10 & $already) {
        $res[1] = Config::get("lang.no_point_for_msg");
        die(json_encode($res));
      }
    } else {
      $res[1] = "you don't login";
      die(json_encode($res));
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
      if ($already) {
        DB::query("UPDATE usr SET point = point - 10 WHERE id = ".$usr_id)->execute();
        if ( is_numeric($_POST['receiver']) ) {
            DB::query("UPDATE usr SET point = point + 5 WHERE id = ".$_POST['receiver'])->execute();
        }
      }
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
