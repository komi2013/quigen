<?php
class Controller_CommentAdd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      Model_Log::warn('wrong usr');
      die(json_encode($res));
    }
    
    try
    {
      if (isset($_GET['pay'])) {
        $comment = new Model_PayComment();
        $comment->txt = $_POST['txt'];
        $comment->usr_id = $usr_id;
        $comment->pay_q_id = $_POST['q'];
        $comment->create_at = date("Y-m-d H:i:s");
        $comment->save();
      } else {
        $comment = new Model_Comment();
        $comment->txt = $_POST['txt'];
        $comment->usr_id = $usr_id;
        $comment->question_id = $_POST['q'];
        $comment->create_at = date("Y-m-d H:i:s");
        $comment->save();
      }

    }
    catch (Orm\ValidationFailed $e)
    {
      $res[1] = $e->getMessage();
      Model_Log::warn('orm err');
      die(json_encode($res));
    }
    $res[0] = 1;
    die(json_encode($res));
  }
}
