<?php
class Controller_4wordadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      Model_Log::warn('wrong usr');
      die(json_encode($res));
    }
    
    $now_limit = new DateTime("now");
    $now_limit->add(new DateInterval('P14D'));
    $query = DB::select()->from('question')
      ->where('usr_id','=',$usr_id)
      ->order_by('open_time', 'desc')
      ->execute()->as_array();
    if ( isset($query[0]['open_time']) ) {
      if ( $query[0]['open_time'] > "2100-01-01 00:00:00" ) {
        $open_time = date("Y-m-d H:i:s",strtotime( $query[0]['open_time']."-100 year") );
      } else {
        $open_time = $query[0]['open_time'];
      }
    } else {
      $open_time = date("Y-m-d H:i:s");
    } 
//    $open_time = Model_Cookie::get('open_time');
    $post_open_time = new DateTime($open_time);
    if ($now_limit < $post_open_time) {
      Model_Log::warn('limited');
      die(json_encode($res));
    }

    $open_time = date("Y-m-d H:i:s",strtotime($open_time."+100 year"));
    $query = DB::select()->from('mt_block_generate')
      ->where('usr_id','=',$usr_id)
      ->execute()->as_array();
    if (isset($query[0])) {
      Model_Log::warn('blocked');
      die(json_encode($res));
    }
    try
    {
      $i = 0;
      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_0']);
      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_1']);
      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_2']);
      
      while ($i < 4) {
        $question = new Model_Question();
        $question_id = $question->get_new_id();
        $question->id = $question_id;
        $question->txt = $_POST['arr_q'][$i];
        $question->usr_id = $usr_id;
        $question->img = '';
        $question->create_at = date("Y-m-d H:i:s");
        $question->open_time = $open_time;
        $question->save();
        $arr_a = $_POST['arr_a'];
        unset($arr_a[$i]);
        $arr_incorrect = array_merge($arr_a); 
        $choice = new Model_Choice();
        $choice->choice_0 = $_POST['arr_a'][$i];
        $choice->choice_1 = $arr_incorrect[0];
        $choice->choice_2 = $arr_incorrect[1];
        $choice->choice_3 = $arr_incorrect[2];
        $choice->question_id = $question_id;
        $choice->save();

        $answer_by_q = new Model_AnswerByQ();
        $answer_by_q->correct = 0;
        $answer_by_q->question_id = $question_id;
        $answer_by_q->amount = 0;
        $answer_by_q->create_at = $open_time;
        $answer_by_q->update_at = $open_time;
        $answer_by_q->save();

        $a_news_time = new Model_ANewsTime();
        $a_news_time->following_u_id = $usr_id;
        $a_news_time->question_id = $question_id;
        $a_news_time->q_img = '';
        $a_news_time->u_img = $_POST['myphoto'];
        $a_news_time->create_at = date( "Y-m-d H:i:s");
        $a_news_time->save();

        $post_open_time->add( new DateInterval('PT1H'));
        $open_time = $post_open_time->format('Y-m-d H:i:s');
        $open_time = date("Y-m-d H:i:s",strtotime($open_time."+100 year"));
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
      //DB::query("DELETE FROM tag WHERE txt = ''")->execute();
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
