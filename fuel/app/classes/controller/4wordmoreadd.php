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

    $arr_post[] = preg_replace('/\W+/u', '_', 'センター英語重要');
    $arr_post[] = preg_replace('/\W+/u', '_', '');
    $arr_post[] = preg_replace('/\W+/u', '_', '');
    
    $arr_word = DB::select()->from('word')
    ->execute()->as_array();
    //->order_by('quiz', 'asc')->limit(12)

    $ii = 1;
    //$arr_word_4 = array();
    foreach ($arr_word as $d) {
      $arr_word_q[] = $d['quiz'];
      $arr_word_a[] = $d['answer'];

      if ( ($ii % 4) == 0 ) {
        $i = 0;
        while ($i < 4) {
          $question = new Model_Question();
          $question_id = $question->get_new_id();
          $question->id = $question_id;
          $question->txt = $arr_word_q[$i].'の意味は？';
          $question->usr_id = 22;
          $question->img = '';
          $question->create_at = date("Y-m-d H:i:s");
          $question->open_time = date("Y-m-d H:i:s");
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

          $a_news_time = new Model_ANewsTime();
          $a_news_time->following_u_id = $usr_id;
          $a_news_time->question_id = $question_id;
          $a_news_time->q_img = '';
          $a_news_time->u_img = ''; //change everytime image
          $a_news_time->create_at = date( "Y-m-d H:i:s");
          $a_news_time->save();

          $i++;
          if ($arr_post[0]) {
            $sql = "INSERT INTO tag (question_id,txt) VALUES (".$question_id.",'".$arr_post[0]."')";
          }
          if ($arr_post[1]) {
            $sql = $sql.",(".$question_id.",'".$arr_post[1]."')";
          }
          if ($arr_post[2]) {
            $sql = $sql.",(".$question_id.",'".$arr_post[2]."')";
          }
          if ($arr_post[0]) {
            DB::query($sql)->execute();
          }
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
