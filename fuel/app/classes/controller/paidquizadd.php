<?php
class Controller_PaidQuizAdd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      die(json_encode($res));
    }
    if (!is_numeric($_POST['pack_id']))
    {
      die(json_encode($res));
    }
    $pack_id = $_POST['pack_id'];
    $question = new Model_PayQ();
    $pay_q_id = $question->get_new_id();
    if ($_POST["img"] == 'no')
    {
      $web_path = '';
    }
    else
    {
      @mkdir(DOCROOT.'assets/img/quiz/'.date('Ymd'), 0777);
      @chmod(DOCROOT.'assets/img/quiz/'.date('Ymd'), 0777);
      $img_path = DOCROOT.'assets/img/quiz/'.date('Ymd').'/pay_'.$pay_q_id.'.png';
      $web_path = '/assets/img/quiz/'.date('Ymd').'/pay_'.$pay_q_id.'.png';
      $canvas = $_POST["img"];
      $canvas = preg_replace("/data:[^,]+,/i","",$canvas);
      $canvas = base64_decode($canvas);
      $image = imagecreatefromstring($canvas);
      imagesavealpha($image, TRUE);
      imagepng($image ,$img_path);
    }
    try
    {
      $question = new Model_PayQ();
      $question->pack_id =  $pack_id;
      $question->id = $pay_q_id;
      $question->txt = $_POST['q_txt'];
      $question->img = $web_path;
      $question->create_at = date("Y-m-d H:i:s");
      $question->save();
      $choice = new Model_PayChoice();
      $choice->choice_0 = $_POST['choice_0'];
      $choice->choice_1 = $_POST['choice_1'];
      $choice->choice_2 = $_POST['choice_2'];
      $choice->choice_3 = $_POST['choice_3'];
      $choice->question_id = $pay_q_id;
      $choice->save();
      
      if ($_POST['q_amt'] > 18){
        //extract sample question
        $offset = rand(0, 20);
        $sample_q = DB::query("select * from pay_q where pack_id = ".$pack_id." limit 1 offset ".$offset)
         ->execute()->as_array();
        $pay_choice = DB::query("select * from pay_choice where question_id = ".$sample_q[0]['id'])
         ->execute()->as_array();
        $question = new Model_Question();
        $question_id = $question->get_new_id();
        $question->id = $question_id;
        $question->txt = $sample_q[0]['txt'];
        $question->usr_id = $usr_id;
        $question->img = $sample_q[0]['img'];
        $question->create_at = date("Y-m-d H:i:s");
        $question->open_time = date("Y-m-d H:i:s");
        $question->save();
        $choice = new Model_Choice();
        $choice->choice_0 = $pay_choice[0]['choice_0'];
        $choice->choice_1 = $pay_choice[0]['choice_1'];
        $choice->choice_2 = $pay_choice[0]['choice_2'];
        $choice->choice_3 = $pay_choice[0]['choice_3'];
        $choice->question_id = $question_id;
        $choice->save();
        
        DB::query("INSERT INTO tag (question_id,txt) VALUES
        (".$question_id.",'".preg_replace('/\W+/u', '_', $_POST['pack_txt'])."'),
        (".$question_id.",'有料')")->execute();
        DB::query("update pack set activate = 1, sample_q = ".$question_id." where id = ".$pack_id)
        ->execute();
        
        $answer_by_q = new Model_AnswerByQ();
        $answer_by_q->correct = 0;
        $answer_by_q->question_id = $question_id;
        $answer_by_q->amount = 0;
        $answer_by_q->update_at = date("Y-m-d H:i:s");
        $answer_by_q->save();
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
