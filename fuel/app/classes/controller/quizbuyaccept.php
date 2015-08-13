<?php
class Controller_QuizBuyAccept extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    if (!is_numeric($_POST['quiz_buy_id']))
    {
      die(json_encode($res));
    }
    $quiz_buy_id = $_POST['quiz_buy_id'];
    $seller_id = Model_Cookie::get_usr();
    if (!$seller_id)
    {
      $res[1] = 'no seller id';
      die(json_encode($res));
    }
    $arr_quiz_buy = DB::query("select * from quiz_buy where id = ".$quiz_buy_id)->execute()->as_array();
    if ($arr_quiz_buy[0]['seller'] != $seller_id) {
      $res[1] = 'seller id is not match';
      die(json_encode($res));
    }
    $arr_question = DB::query("select * from question where id = ".$arr_quiz_buy[0]['question_id'])->execute()->as_array();
    $arr_choice = DB::query("select * from choice where question_id = ".$arr_quiz_buy[0]['question_id'])->execute()->as_array();
    $arr_pack = DB::query("select * from pack where id = ".$arr_quiz_buy[0]['buyer']." AND activate = 0 order by id desc")->execute()->as_array();
    if (!isset($arr_pack[0]['id'])) {
      $res[0] = 3;
      $res[1] = 'バイヤーのパックが作成されていません';
      die(json_encode($res));
    }
    $query = DB::query("select point from usr where id = ".$arr_quiz_buy[0]['buyer'])->execute()->as_array();
    $point = $query[0]['point'];
    if ($point < $arr_quiz_buy[0]['point'])
    {
      $res[0] = 3;
      $res[1] = 'バイヤーのポイントが足りません';
      die(json_encode($res));
    }

    try
    {
      $cnt_pay_q = DB::query("select count(*) from pay_q where pack_id = ".$arr_pack[0]['id'])->execute()->as_array();
      $seq_pay_q = $cnt_pay_q[0]['count'] + 1;

      $question = new Model_PayQ();
      $question->pack_id =  $arr_pack[0]['id'];
      $question->id = $arr_quiz_buy[0]['question_id'];
      $question->txt = $arr_question[0]['txt'];
      $question->img = $arr_question[0]['img'];
      $question->create_at = date("Y-m-d H:i:s");
      $question->save();
      $choice = new Model_PayChoice();
      $choice->choice_0 = $arr_choice[0]['choice_0'];
      $choice->choice_1 = $arr_choice[0]['choice_1'];
      $choice->choice_2 = $arr_choice[0]['choice_2'];
      $choice->choice_3 = $arr_choice[0]['choice_3'];
      $choice->question_id = $arr_quiz_buy[0]['question_id'];
      $choice->save();

      if ($cnt_pay_q[0]['count'] > 18) {
        //extract sample question
        $offset = rand(0, 20);
        $sample_q = DB::query("select * from pay_q where pack_id = ".$arr_pack[0]['id']." limit 1 offset ".$offset)
         ->execute()->as_array();
        $pay_choice = DB::query("select * from pay_choice where question_id = ".$sample_q[0]['id'])
         ->execute()->as_array();
        $question = new Model_Question();
        $question_id = $question->get_new_id();
        $question->id = $question_id;
        $question->txt = $sample_q[0]['txt'];
        $question->usr_id = $seller_id;
        $question->img = $sample_q[0]['img'];
        $question->create_at = date("Y-m-d H:i:s");
        $question->save();
        $choice = new Model_Choice();
        $choice->choice_0 = $pay_choice[0]['choice_0'];
        $choice->choice_1 = $pay_choice[0]['choice_1'];
        $choice->choice_2 = $pay_choice[0]['choice_2'];
        $choice->choice_3 = $pay_choice[0]['choice_3'];
        $choice->question_id = $question_id;
        $choice->save();
        $res = DB::query("INSERT INTO tag (question_id,txt) VALUES
          (".$question_id.",'".preg_replace('/\W+/u', '_', $arr_pack[0]['txt'])."')")->execute();
        DB::query("update pack set activate = 1, sample_q = ".$question_id." where id = ".$arr_pack[0]['id'])
         ->execute();
      }
      DB::query("delete from quiz_buy where id = ".$quiz_buy_id)->execute();
      if ($arr_quiz_buy[0]['point'] == 20) {
        DB::start_transaction();
        DB::query("update usr set point = point + 10 where id = ".$seller_id)->execute();
        DB::query("update usr set point = point - 20 where id = ".$arr_quiz_buy[0]['buyer'])->execute();
        DB::query("INSERT INTO lg_quiz_buy_tran (seller,buyer,quiz_id,point,create_at) VALUES
          (".$seller_id.",".$arr_quiz_buy[0]['buyer'].",".$arr_quiz_buy[0]['question_id'].",20,'".date('Y-m-d H:i:s')."')")->execute();
        DB::commit_transaction();
      }
      
    }
    catch (Orm\ValidationFailed $e)
    {
      DB::rollback_transaction();
      $res[1] = $e->getMessage();
      die(json_encode($res));
    }
    
    $res[0] = 1;
    $res[1] = $point;
    die(json_encode($res));
  }
}
