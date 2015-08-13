<?php
class Controller_Paidanswer extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    if (!is_numeric($_POST['question']))
    {
      die(json_encode($res));
    }
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      die(json_encode($res));
    }
    
    $pay_choice = DB::select()->from('pay_choice')
      ->where('question_id','=',$_POST['question'])
      ->execute()->as_array();
    $pay_choice[0]['choice_0'];
    if ($pay_choice[0]['choice_0'] == $_POST['answer'])
    {
      $res[1] = 1;
    }
    else
    {
      $res[1] = 2;
    }
    $correct_choice_num = -1;
    foreach ($_POST['arr_choice'] as $k => $d)
    {
      if ($d == $pay_choice[0]['choice_0'])
      {
        $correct_choice_num = $k;
      }
    }
    $res[2] = $correct_choice_num;
    $res[3] = $pay_choice[0]['choice_0'];
    $correct = DB::select()->from('pay_correct')
      ->where('usr_id','=',$usr_id)
      ->and_where('pay_q_id','=',$_POST['question'])
      ->order_by('id','asc')
      ->execute()->as_array();
    $arr_res = array();
    $status = 0;
    if (isset($correct[0]['id'])) {
      $status = 1;
    }
    $incorrect = DB::select()->from('pay_incorrect')
      ->where('usr_id','=',$usr_id)
      ->and_where('pay_q_id','=',$_POST['question'])
      ->order_by('id','asc')
      ->execute()->as_array();
    if (isset($incorrect[0]['id'])) {
      $status = 1;
    }

    if ($status > 0) {
      $res[0] = 1;
      die(json_encode($res));
    }
    
    try
    {
      $answer_by_q = Model_AnswerByPayQ::find('first', array(
        'where' => array(
          array('pay_q_id', $_POST['question']),
        ),
      ));
      if (isset($answer_by_q->pay_q_id))
      {
        if ($res[1] == 1)
        {
          $answer_by_q->correct++;
        }
        $answer_by_q->amount++;
        $answer_by_q->update_at = date("Y-m-d H:i:s");
      }
      else
      {
        $answer_by_q = new Model_AnswerByPayQ();
        if ($res[1] == 1)
        {
          $answer_by_q->correct = 1;
        }
        $answer_by_q->pay_q_id = $_POST['question'];
        $answer_by_q->amount = 1;
        $answer_by_q->update_at = date("Y-m-d H:i:s");
      }
      $answer_by_q->save();

      if ($res[1] == 1)
      {
        $correct = new Model_PayCorrect();
        $correct->pay_q_id = $_POST['question'];
        $correct->usr_id = $usr_id;
        $correct->create_at = date("Y-m-d H:i:s");
      	$correct->save();
      }
      else
      {
        $incorrect = new Model_PayIncorrect();
        $incorrect->pay_q_id = $_POST['question'];
        $incorrect->usr_id = $usr_id;
        $incorrect->create_at = date("Y-m-d H:i:s");
      	$incorrect->save();
      }

      $answered_news = Model_PayAnswerednews::find('first', array(
        'where' => array(
          array('pay_q_id', $_POST['question']),
          array('usr_id', $_POST['usr']),
        ),
      ));

      if (isset($answered_news->id))
      {
//         $answered_news = new Model_Answerednews();
        $answered_news->summary++;
        $answered_news->pay_q_id = $_POST['question'];
        $answered_news->usr_id = $_POST['usr'];
        $answered_news->update_at = date("Y-m-d H:i:s");
      }
      else
      {
        $answered_news = new Model_PayAnswerednews();
        $answered_news->summary = 1;
        $answered_news->pay_q_id = $_POST['question'];
        $answered_news->q_txt = $_POST['q_txt'];
        $answered_news->q_img = $_POST['q_img'];
        $answered_news->usr_id = $_POST['usr'];
        $answered_news->update_at = date("Y-m-d H:i:s");
      }
      $answered_news->save();
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
