<?php
class Controller_Forumadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
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

    $forum = new Model_Forum();
    $forum_id = $forum->get_new_id();
    if ($_POST["img"] == 'no')
    {
      $web_path = '';
    }
    else
    {
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
    $parent_id = isset( $_POST['f_id'] ) ? $_POST['f_id'] : 0 ;
    try
    {
      $forum = new Model_Forum();
      $forum->id = $forum_id;
      $forum->parent_id = $parent_id;
      $forum->txt = $_POST['txt'];
      $forum->img = $web_path;
      $forum->usr_id = $usr_id;
      $forum->update_at = date("Y-m-d H:i:s");
      $forum->open_time = $open_time;
      $forum->u_img = $_POST['myphoto'];
      $forum->nice = 0;
      $forum->save();
    }
    catch (Orm\ValidationFailed $e)
    {
      $res[1] = $e->getMessage();
      Model_Log::warn($res[1]);
      die(json_encode($res));
    }
    $res[0] = 1;
    $res[1] = isset( $_POST['f_id'] ) ? $_POST['f_id'] : $forum_id;
    die(json_encode($res));
  }
}
