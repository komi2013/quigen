<?php
class Controller_4wordmoreadd extends Controller
{
  public function action_index()
  {
    //9525 ~ 9542
    ini_set("memory_limit","1256M");
    ini_set('max_execution_time', 30000);
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    $i2 = 0;
    $arr = DB::query("select * from z_pic_sound where big_category = 'animal' and representative is not null"
            . " order by small_category, id ")->execute()->as_array();
    $ii = 1; $i2++;
    $wh_time = 1468558311; //change
    try {
      DB::start_transaction();
      foreach ($arr as $d) {
        //change
        $arr_word_q[] = $d['name'].'は？';
        $arr_word_a[] = '/content/image/animal/' .$d['name'].'.jpg';
        $arr_word_s[] = '/content/sound/baby_animal/' .$d['representative'].'.mp3';

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
            $choice->question_type = 1;
//            $sound1 = str_replace("image", "sound", $arr_word_a[$i]);
//            echo $sound1.$d['name'].$d['representative'].'<br>';
//            $sound2 = str_replace($d['name'], $d['representative'], $sound1);
//            echo $sound2.'<br>';
            $choice->sound = $arr_word_s[$i];
            $choice->save();

            $answer_by_q = new Model_AnswerByQ();
            $answer_by_q->correct = 0;
            $answer_by_q->question_id = $question_id;
            $answer_by_q->amount = 0;
            $answer_by_q->create_at = date("Y-m-d H:i:s");
            $answer_by_q->update_at = date("Y-m-d H:i:s");
            $answer_by_q->save();

            DB::query("INSERT INTO tag (question_id,txt,open_time,quiz_num) VALUES (".
            $question_id.",'幼児でもわかる動物','".date("Y-m-d H:i:s", $wh_time)."',".$i2.")")
            ->execute(); //change
//            if ($arr_comment[$i]) {
//              $sql = "INSERT INTO comment (txt,usr_id,question_id,create_at,u_img) VALUES (:txt".
//                ",33,".$question_id.",'".date("Y-m-d H:i:s", $wh_time)."','/assets/img/profile/20160624/33.png')";
//              DB::query($sql)->bind('txt', $arr_comment[$i])->execute(); //change            
//            }
            $i++; $i2++;
          }
          $arr_word_q = [];
          $arr_word_a = [];
          $arr_word_s = [];
          $arr_comment = [];
        }
        ++$ii;
      }
      DB::commit_transaction();
      $res[0] = 1;
      die(json_encode($res));
    } catch (Exception $e) {
      var_dump($e->getMessage());
      $res[1] = $e;
      DB::rollback_transaction();
      $res[0] = 2;
      
      die(json_encode($res));
    }
  }
}
