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
    $forum_id = $_POST['f_id'];
    $txt = $_POST['txt'];
    $coin_icon = '<img src="/assets/img/icon/coin.png" class="icon">';
    $coin_cnt = mb_substr_count($txt, $coin_icon);
    $point = $coin_cnt * 10;
    if ($coin_cnt > 0) {
        $query = DB::select()->from('usr')->where('id','=',$usr_id)->execute()->as_array();
        if ( isset($query[0]['id']) ) {
            if ($query[0]['point'] < $point) {
                $point = floor(($query[0]['point']/10))*10;
            }
        } else {
            $point = 0;
        }
        $txt = str_replace($coin_icon,'',$txt);
    }
    if ($coin_cnt > 0 AND $point < 1) {
        $res[1] = "you don't have enough point";
        die(json_encode($res));
    }
    if ($point > 0) {
      $query = DB::select()->from('forum')->where('id','=',$forum_id)->execute()->as_array();
      DB::query("UPDATE usr SET point = point - ".$point." WHERE id = ".$usr_id)->execute();
      DB::query("UPDATE usr SET point = point + ". $point/2 ." WHERE id = ".$query[0]['usr_id'])->execute();
    }
    $search = array_keys(Model_Emoji::$table);
    $replace = array_values(Model_Emoji::$table);
    $txt = str_replace($search,$replace,$txt);
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
        'point' => $point,
      ));
      $query->execute();
      DB::query("UPDATE usr SET forum_comment = forum_comment + 1 WHERE id = ".$usr_id)->execute();
      $query = DB::update('forum');
      $query->set(array(
        'open_time' => date("Y-m-d H:i:s"),
      ));
      $query->where('id', '=', $forum_id);
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
