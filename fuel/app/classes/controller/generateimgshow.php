<?php
class Controller_Generateimgshow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    Model_Csrf::setcsrf();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      Model_Log::warn('no usr');
      die(json_encode($res));
    }
    $img = $_GET['url'];
    if( exif_imagetype($img) ) {
      $img = file_get_contents($_GET['url']);
      header('Content-type: image/jpeg');
      die( $img );
    }
  }
}
