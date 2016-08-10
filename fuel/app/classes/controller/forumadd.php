<?php
class Controller_Forumadd extends Controller
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
    
    //$open_time = date("Y-m-d H:i:s",strtotime("+100 year"));
    $open_time = date("Y-m-d H:i:s");
    $query = DB::select()->from('mt_block_generate')
      ->where('usr_id','=',$usr_id)
      ->execute()->as_array();
    if ( isset($query[0]) ) {
      Model_Log::warn('blocked');
      die( json_encode($res) );
    }
     $query = DB::query("select nextval('forum_id_seq')")->execute();
     foreach ($query as $d) {
       //var_dump($d['nextval']);
       $forum_id = $d['nextval'];
     }
     //$forum_id = $res[0]['nextval'];
    if ($_POST["img"] == 'no') {
      $web_path = '';
    } else {
      @mkdir(DOCROOT.'assets/img/forum/'.date('Ymd'), 0777);
      @chmod(DOCROOT.'assets/img/forum/'.date('Ymd'), 0777);
      $img_path = DOCROOT.'assets/img/forum/'.date('Ymd').'/'.$forum_id.'.png';
      $web_path = '/assets/img/forum/'.date('Ymd').'/'.$forum_id.'.png';
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
    $search = array_keys($arr);
    $replace = array_values($arr);
    $txt = str_replace($search,$replace,$txt);
    
    try {
      $query = DB::insert('forum');
      $query->set(array(
        'id' => $forum_id,
        'txt' => $txt,
        'img' => $web_path,
        'usr_id' => $usr_id,
        'update_at' => date("Y-m-d H:i:s"),
        'open_time' => $open_time,
        'u_img' => $_POST['myphoto'],
        'u_name' => $_POST['myname'],
        'nice' => 0,
      ));
      $query->execute();
    } catch (Exception $e) {
      $res[1] = $e->getMessage();
      Model_Log::warn($res[1]);
      die(json_encode($res));
    }
    $res[0] = 1;
    $res[1] = isset( $_POST['f_id'] ) ? $_POST['f_id'] : $forum_id;
    die(json_encode($res));
  }
}
