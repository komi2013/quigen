<?php
class Controller_4wordmoreadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    $arr = DB::query("select * from ".$_GET['table']."")->execute()->as_array();
    $ii = 1; $i2 = 1;
    $wh_time = 1453448861; //change
    
    foreach ($arr as $d) {
      //change
      $arr_word_q[] = $d['col2']."\r\n".$_GET['imi'];
      $arr_word_a[] = $d['col1'];

      if ( ($ii % 4) == 0 ) {
        $i = 0;

        while ($i < 4) {
          $wh_time += 60; //sometimes change
          $question = new Model_Question();
          $question_id = $question->get_new_id();
          $question->id = $question_id;
          $question->txt = $arr_word_q[$i];
          $question->usr_id = 33; //sometimes change
          $question->img = '';
          $question->create_at = date("Y-m-d H:i:s");
          $question->open_time = date("Y-m-d H:i:s", $wh_time);
          $question->save();
          $arr_a = $arr_word_a;
          unset($arr_a[$i]);
          $arr_incorrect = array_merge($arr_a); 
          $choice = new Model_Choice();
          $choice->choice_0 = $arr_word_a[$i];
          $choice->choice_1 = $arr_incorrect[0];
          $choice->choice_2 = $arr_incorrect[1];
          $choice->choice_3 = $arr_incorrect[2];
          $choice->question_id = $question_id;
          $choice->save();

          $answer_by_q = new Model_AnswerByQ();
          $answer_by_q->correct = 0;
          $answer_by_q->question_id = $question_id;
          $answer_by_q->amount = 0;
          $answer_by_q->create_at = date("Y-m-d H:i:s");
          $answer_by_q->update_at = date("Y-m-d H:i:s");
          $answer_by_q->save();
  DB::query("INSERT INTO tag (question_id,txt,open_time,quiz_num) VALUES (".
  $question_id.",'".$_GET['tag']."','".date("Y-m-d H:i:s", $wh_time)."',".$i2.")")
  ->execute(); //change

          $i++; $i2++;
        }
        $arr_word_q = [];
        $arr_word_a = [];
      }
      ++$ii;
    }
    
    
    
    $res[0] = 1;

    die(json_encode($res));
  }
}
