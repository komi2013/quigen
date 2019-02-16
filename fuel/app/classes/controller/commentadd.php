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
    $txt = htmlspecialchars($_POST['txt'], ENT_QUOTES);
    $u_img = htmlspecialchars($_POST['u_img'], ENT_QUOTES);
    $u_name = htmlspecialchars($_POST['u_name'], ENT_QUOTES);
    try
    {
      $query = DB::insert('comment');
      $query->set(array(
        'txt' => $txt,
        'u_img' => $u_img,
        'usr_id' => $usr_id,
        'question_id' => $_POST['q'],
        'create_at' => date("Y-m-d H:i:s"),
      ));
      $query->execute();

      $arr = DB::select()->from('forum')
        ->where('question_id','=',$_POST['q'])
        ->execute()->as_array();
      if(isset($arr[0]['id'])){
        $query = DB::insert('forum_comment');
        $query->set(array(
          'forum_id' => $arr[0]['id'],
          'txt' => $txt,
          'usr_id' => $usr_id,
          'update_at' => date("Y-m-d H:i:s"),
          'open_time' => date("Y-m-d H:i:s"),
          'u_img' => $u_img,
          'u_name' => $u_name,
          'nice' => 0,
        ));
        $query->execute();          
      }
      DB::update('forum')
        ->value("open_time",date("Y-m-d H:i:s"))
        ->where('id','=',$arr[0]['id'])
        ->execute();
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
