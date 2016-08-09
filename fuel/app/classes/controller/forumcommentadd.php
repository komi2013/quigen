<?php
class Controller_Forumcommentadd extends Controller
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
    $query = DB::query("select nextval('forum_comment_id_seq')")->execute();
    foreach ($query as $d) {
      $forum_comment_id = $d['nextval'];
    }
    if ($_POST["img"] == 'no') {
      $web_path = '';
    } else {
      @mkdir(DOCROOT.'assets/img/forumcomment/'.date('Ymd'), 0777);
      @chmod(DOCROOT.'assets/img/forumcomment/'.date('Ymd'), 0777);
      $img_path = DOCROOT.'assets/img/forumcomment/'.date('Ymd').'/'.$forum_comment_id.'.png';
      $web_path = '/assets/img/forumcomment/'.date('Ymd').'/'.$forum_comment_id.'.png';
      $canvas = $_POST["img"];
      $canvas = preg_replace("/data:[^,]+,/i","",$canvas);
      $canvas = base64_decode($canvas);
      $image = imagecreatefromstring($canvas);
      imagesavealpha($image, TRUE);
      imagepng($image ,$img_path);
    }
    //echo '<pre>';
    $forum_id = $_POST['f_id'];
    //var_dump($_POST['txt']);
    $txt = htmlspecialchars($_POST['txt'], ENT_QUOTES);
    //var_dump($txt);
    $search = array_keys(Model_Emoji::$table);
    $replace = array_values(Model_Emoji::$table);
    $txt = str_replace($search,$replace,$txt);
    //var_dump($txt);
    //echo '</pre>';
    //die();
    try {
      $query = DB::insert('forum_comment');
      $query->set(array(
        'id' => $forum_comment_id,
        'forum_id' => $forum_id,
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
    $res[1] = $forum_id;
    die(json_encode($res));
  }
}
