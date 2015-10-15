<?php
class Controller_4wordmoreadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    $auth = false;
    foreach (Config::get('my.adm') as $d)
    {
      if ($d == $usr_id)
      {
        $auth = true;
      }
    }
    if (!$auth AND $_SERVER['REMOTE_ADDR'] != '133.242.146.131')
    {
      die(json_encode($res));
    }
  if (isset($_GET['wh'])) {
    $arr = DB::select()->from('wh_4choice')
             ->execute()->as_array();
    $wh_time = 1444906641;
    foreach ($arr as $d) {
          $wh_time += 60;
          $question = new Model_Question();
          $question_id = $question->get_new_id();
          $question->id = $question_id;
          $question->txt = $d['Q'];
          $question->usr_id = 33;
          $question->create_at = date("Y-m-d H:i:s");
          $question->open_time = date("Y-m-d H:i:s", $wh_time);
          $question->save();
          $choice = new Model_Choice();
          $choice->choice_0 = $d['A1'];
          $choice->choice_1 = $d['A2'];
          $choice->choice_2 = $d['A3'];
          $choice->choice_3 = $d['A4'];
          $choice->question_id = $question_id;
          $choice->save();

          $answer_by_q = new Model_AnswerByQ();
          $answer_by_q->correct = 0;
          $answer_by_q->question_id = $question_id;
          $answer_by_q->amount = 0;
          $answer_by_q->create_at = date("Y-m-d H:i:s");
          $answer_by_q->update_at = date("Y-m-d H:i:s");
          $answer_by_q->save();
          
          DB::query("INSERT INTO tag (question_id,txt) VALUES (".$question_id.",'センター日本史')")->execute();
      
    }
    $res[0] = 1;
    die(json_encode($res));
  }

  if (isset($_GET['seq'])) {
    $arr = DB::query("SELECT * FROM question WHERE id IN ( SELECT question_id FROM tag WHERE txt = 'センター世界史' ) ORDER BY open_time ")->execute();
    $wh_time = 1438387200;
    foreach ($arr as $d) {
      $wh_time += 60;
      DB::query("update question set open_time = '".date("Y-m-d H:i:s", $wh_time)."' where id = ".$d['id'])->execute();
      
    }
    $res[0] = 1;
    die(json_encode($res));
  }  

  $arr_word = DB::select()->from('wh_treaty')
    ->execute()->as_array();
    //->order_by('quiz', 'asc')->limit(12)

    $ii = 1;
    //$arr_word_4 = array();
    $wh_time = 1438387230;
    
    foreach ($arr_word as $d) {
      //year,comment
      $arr_word_q[] = $d['item'].'に該当する年代は？';
      $arr_word_a[] = $d['year'];

      if ( ($ii % 4) == 0 ) {
        $i = 0;

        while ($i < 4) {
          $wh_time += 300;
          $question = new Model_Question();
          $question_id = $question->get_new_id();
          $question->id = $question_id;
          $question->txt = $arr_word_q[$i];
          $question->usr_id = 33;
          $question->img = '';
          $question->create_at = date("Y-m-d H:i:s");
          $question->open_time = date("Y-m-d H:i:s", $wh_time);
          $question->save();
          $arr_a = $arr_word_a;
          unset($arr_a[$i]);
          $arr_incorrect = array_merge($arr_a); 
          $choice = new Model_Choice();
          $choice->choice_0 = $arr_word_a[$i];
          $choice->choice_1 = $arr_incorrect[0] + 4;
          $choice->choice_2 = $arr_incorrect[1] -5;
          $choice->choice_3 = $arr_incorrect[2] +6;
          $choice->question_id = $question_id;
          $choice->save();

          $answer_by_q = new Model_AnswerByQ();
          $answer_by_q->correct = 0;
          $answer_by_q->question_id = $question_id;
          $answer_by_q->amount = 0;
          $answer_by_q->create_at = date("Y-m-d H:i:s");
          $answer_by_q->update_at = date("Y-m-d H:i:s");
          $answer_by_q->save();

          $i++;
          DB::query("INSERT INTO tag (question_id,txt) VALUES (".$question_id.",'センター世界史')")->execute();
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
