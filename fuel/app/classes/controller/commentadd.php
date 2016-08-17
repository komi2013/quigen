<?php
class Controller_CommentAdd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
      Model_Log::warn('wrong usr');
      die(json_encode($res));
    }
    if ( !is_numeric($_POST['q']) ) {
      Model_Log::warn('wrong post q');
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
        $query = DB::insert('comment');
        $query->set(array(
          'txt' => $_POST['txt'],
          'u_img' => htmlspecialchars($_POST['u_img'], ENT_QUOTES),
          'usr_id' => $usr_id,
          'question_id' => $_POST['q'],
          'create_at' => date("Y-m-d H:i:s"),
        ));
        $query->execute();
      }
      
      $txt = htmlspecialchars($_POST['txt'], ENT_QUOTES);
      $txt = nl2br($txt);
      $txt .= '<br>&nbsp;&nbsp;<a href="/quiz/?q='.$_POST['q'].'" contenteditable="false">go to quiz</a>';
      $query = DB::insert('forum');
      $query->set(array(
        'txt' => $txt,
        'usr_id' => $usr_id,
        'update_at' => date("Y-m-d H:i:s"),
        'open_time' => date("Y-m-d H:i:s"),
        'u_img' => $_POST['u_img'],
        'u_name' => $_POST['u_name'],
      ));
      $query->execute();
      DB::query("UPDATE usr SET forum = forum + 1 WHERE id = ".$usr_id)->execute();
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
