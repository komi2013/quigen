<?php
class Controller_Photoprofileadd extends Controller
{
  public function action_index()
  {
    Model_Csrf::check();
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      Model_Log::warn('no usr');
      die(json_encode($res));
    }
    
    @mkdir(DOCROOT.'assets/img/profile/'.date('Ymd'), 0777);
    @chmod(DOCROOT.'assets/img/profile/'.date('Ymd'), 0777);
    $img_path = DOCROOT.'assets/img/profile/'.date('Ymd').'/'.$usr_id.'.png';
    $web_path = '/assets/img/profile/'.date('Ymd').'/'.$usr_id.'.png';
    $canvas = $_POST["img"];
    $canvas = preg_replace("/data:[^,]+,/i","",$canvas);
    $canvas = base64_decode($canvas);
    $image = imagecreatefromstring($canvas);
    imagesavealpha($image, TRUE);
    imagepng($image ,$img_path);
    $res[0] = 1;
    $res[1] = $web_path;
    die(json_encode($res));
  }
}
