<?php
class Controller_Followingconfirm extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id OR !isset($_POST['sender']) OR !is_numeric($_POST['sender']) )
    {
      //at first, you must answer
      $res[1] = 'you must answer first';
      die(json_encode($res));
    }
    Model_Csrf::check();
    $query = DB::query("SELECT * FROM follow WHERE receiver = ".$usr_id." AND sender = ".$_POST['sender'])
      ->execute()->as_array();
    
    if ($query[0]['status'] == 2) {
      $res[0] = 1;
      Model_Log::warn('already status 2');
      die( json_encode($res) );
    }
    try
    {
      DB::query("UPDATE follow SET status = 2 WHERE receiver = ".$usr_id." AND sender = ".$_POST['sender'])->execute();
      $private_news = new Model_PrivateNews();
      $private_news->usr_id = $_POST['sender'];
      $receiver_img = preg_replace('/http/', 'url', $_POST['receiver_img']);
      if ($receiver_img) {
        $receiver_img = $receiver_img;
        $css = '';
      } else {
        $util = new Model_Util();
        $util->eto($usr_id);
        $receiver_img = $util->eto_img;
        $css = $util->eto_css;
      }
      $txt = '<a href="/profile/?u='.$usr_id.'">'
        .'<img src="'.$receiver_img.'" class="icon edge_click" '.$css.' ></a>&nbsp;'
        .'<img src="/assets/img/icon/success.png" alt="success" class="icon">'
      ;
      $private_news->txt = $txt;
      $private_news->create_at = date("Y-m-d H:i:s");
      $private_news->save();
    }
    catch (Orm\ValidationFailed $e)
    {
      $res[1] = $e->getMessage();
      die(json_encode($res));
    }
    $res[0] = 1;
    die(json_encode($res));
  }
}
