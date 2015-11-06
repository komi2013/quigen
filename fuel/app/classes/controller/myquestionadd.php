<?php
class Controller_Myquestionadd extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    Model_Csrf::check();
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id)
    {
      Model_Log::warn('no usr');
      die(json_encode($res));
    }
    
    $now_limit = new DateTime("now");
    $now_limit->add(new DateInterval('P30D'));
    
    $query = DB::select()->from('question')
      ->where('usr_id','=',$usr_id)
      ->order_by('open_time', 'desc')
      ->execute()->as_array();
    if ( isset($query[0]['open_time']) ) {
      if ( $query[0]['open_time'] > "2100-01-01 00:00:00" ) {
        $open_time = date("Y-m-d H:i:s",strtotime( $query[0]['open_time']."-100 year") );
      } else if ( $query[0]['open_time'] < date("Y-m-d H:i:s") ) {
        $open_time = date("Y-m-d H:i:s");
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
    $open_time = date("Y-m-d H:i:s",strtotime($open_time."+1 hour"));
    $query = DB::select()->from('mt_block_generate')
      ->where('usr_id','=',$usr_id)
      ->execute()->as_array();
    if ( isset($query[0]) ) {
      Model_Log::warn('blocked');
      die( json_encode($res) );
    }

    $question = new Model_Question();
    $question_id = $question->get_new_id();
    if ($_POST["img"] == 'no')
    {
      $web_path = '';
    }
    else
    {
      @mkdir(DOCROOT.'assets/img/quiz/'.date('Ymd'), 0777);
      @chmod(DOCROOT.'assets/img/quiz/'.date('Ymd'), 0777);
      $img_path = DOCROOT.'assets/img/quiz/'.date('Ymd').'/'.$question_id.'.png';
      $web_path = '/assets/img/quiz/'.date('Ymd').'/'.$question_id.'.png';
      $canvas = $_POST["img"];
      $canvas = preg_replace("/data:[^,]+,/i","",$canvas);
      $canvas = base64_decode($canvas);
      $image = imagecreatefromstring($canvas);
      imagesavealpha($image, TRUE);
      imagepng($image ,$img_path);
    }
    try
    {
      $question = new Model_Question();
//       $question_id = $question->get_new_id();
      $question->id = $question_id;
      $question->txt = $_POST['q_txt'];
      $question->usr_id = $usr_id;
      $question->img = $web_path;
      $question->create_at = date("Y-m-d H:i:s");
      $question->open_time = $open_time;
      $question->save();
      
      $choice = new Model_Choice();
      $choice->choice_0 = $_POST['choice_0'];
      $choice->choice_1 = $_POST['choice_1'];
      $choice->choice_2 = $_POST['choice_2'];
      $choice->choice_3 = $_POST['choice_3'];
      $choice->question_id = $question_id;
      $choice->reference = $_POST['reference'] ?: '';
      $choice->save();

      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_0']);
      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_1']);
      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_2']);
      
      if ($arr_post[0]) {
        $sql = "INSERT INTO tag (question_id,txt,open_time) VALUES (".$question_id.",'".$arr_post[0]."','".$open_time."')";
      }
      if ($arr_post[1]) {
        $sql = $sql.",(".$question_id.",'".$arr_post[1]."','".$open_time."')";
      }
      if ($arr_post[2]) {
        $sql = $sql.",(".$question_id.",'".$arr_post[2]."','".$open_time."')";
      }
      if ($arr_post[0]) {
        DB::query($sql)->execute();
      }
      
      $answer_by_q = new Model_AnswerByQ();
      $answer_by_q->correct = 0;
      $answer_by_q->question_id = $question_id;
      $answer_by_q->amount = 0;
      $answer_by_q->create_at = $open_time;
      $answer_by_q->update_at = $open_time;
      $answer_by_q->save();

//      $a_news_time = new Model_ANewsTime();
//      $a_news_time->following_u_id = $usr_id;
//      $a_news_time->question_id = $question_id;
//      $a_news_time->q_img = $web_path;
//      $a_news_time->u_img = $_POST['myphoto'];
//      $a_news_time->create_at = date( "Y-m-d H:i:s" );
//      $a_news_time->generator = $usr_id;
//      $a_news_time->save();
    }
    catch (Orm\ValidationFailed $e)
    {
      $res[1] = $e->getMessage();
      Model_Log::warn($res[1]);
      die(json_encode($res));
    }
    $res[0] = 1;

    $json_arr_q_data = json_encode(array($question_id,$_POST['q_txt'],$web_path,$usr_id));
    $q_data = Crypt::encode($json_arr_q_data,Config::get('crypt_key.q_data'));
    $res[1] = $q_data;
    die(json_encode($res));
  }
}
