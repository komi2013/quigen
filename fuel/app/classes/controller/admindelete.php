<?php
class Controller_Admindelete extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) die(json_encode($res));
    $auth = false;
    foreach (Config::get('my.adm') as $d)
    {
      if ($d == $usr_id)
      {
        $auth = true;
      }
    }
    if (!$auth)
    {
      $res[1] = 'no right';
      die(json_encode($res));
    }
    if (isset($_POST['arr_quiz']))
    {
      $question = DB::select()->from('question')->where('id','in',$_POST['arr_quiz'])->execute()->as_array();
      foreach ($question as $k => $d)
      {
        @unlink(substr(DOCROOT, 0, -1).$d['img']);
      }
      $post_quiz = $_POST['arr_quiz'];
    }
    else
    {
      $post_quiz = array(0);
    }
    if (isset($_POST['arr_usr']))
    {
      $usr = DB::select()->from('usr')->where('id','in',$_POST['arr_usr'])->execute()->as_array();
      foreach ($usr as $k => $d)
      {
        @unlink(substr(DOCROOT, 0, -1).$d['img']);
      }
      $post_usr = $_POST['arr_usr'];
    }
    else
    {
      $post_usr = array(0);
    }
    try
    {
      DB::delete('question')->where('id','in',$post_quiz)->execute();
      DB::delete('choice')->where('question_id','in',$post_quiz)->execute();
      DB::delete('answer_by_q')->where('question_id','in',$post_quiz)->execute();
      DB::delete('correct')->where('question_id','in',$post_quiz)->execute();
      DB::delete('incorrect')->where('question_id','in',$post_quiz)->execute();
      DB::delete('usr')->where('id','in',$post_usr)->execute();
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
