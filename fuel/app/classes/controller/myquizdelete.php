<?php
class Controller_Myquizdelete extends Controller
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
    if ( !isset($_POST['quiz_id'][0]) ) {
      Model_Log::warn('no quiz_id arr');
      die(json_encode($res));
    }
    $question = DB::select()->from('question')->where('id','in',$_POST['quiz_id'])
      ->and_where('usr_id','=',$usr_id)->execute()->as_array();
    $quiz_id = array();
    foreach ($question as $k => $d)
    {
      @unlink(substr(DOCROOT, 0, -1).$d['img']);
      $quiz_id[] = $d['id'];
    }
    try
    {
      DB::delete('question')->where('id','in',$quiz_id)->execute();
      DB::delete('answer_by_q')->where('question_id','in',$quiz_id)->execute();
      DB::delete('tag')->where('question_id','in',$quiz_id)->execute();
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
