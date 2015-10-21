<?php
class Controller_Followingadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      $res[1] = 'you must answer first';
      die(json_encode($res));
    }
    Model_Csrf::check();
    
    try
    {
      $follow = new Model_Follow();
      $follow->receiver = $_POST['receiver'];
      $follow->sender = $usr_id;
      $follow->create_at = date("Y-m-d H:i:s");
      $follow->status = 1;
      $follow->save();

      $query = DB::select()->from('followed_news')
        ->where('receiver','=',$_POST['receiver'])
        ->and_where('sender','=',$usr_id)
        ->execute()->as_array();
      if (!isset($query->id))
      {
        $followed_news = new Model_Followednews();
        $followed_news->receiver = $_POST['receiver'];
        $followed_news->sender = $usr_id;
        $followed_news->sender_img = $_POST['myphoto'];
        $followed_news->create_at = date("Y-m-d H:i:s");
        $followed_news->save();
      }
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
