<?php
class Controller_Myquestionadd extends Controller
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
    $auth = false;
    foreach (Config::get('my.adm') as $d) {
      if ($d == $usr_id) {
        $auth = true;
      }
    }
    if (!$auth) {
      $open_time = date("Y-m-d H:i:s",strtotime($open_time."+100 year"));
    }
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
    if ($_POST["img"] == 'no') {
      $web_path = '';
    } else {
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
      $question->txt = preg_replace('/\[|\[|[\t]|\\\/u', ' ', $_POST['q_txt']);
      $question->usr_id = $usr_id;
      $question->img = $web_path;
      $question->create_at = date("Y-m-d H:i:s");
      $question->open_time = $open_time;
      $question->save();
      
      $choice = new Model_Choice();
      $choice->choice_0 = preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $_POST['choice_0']);
      $choice->choice_1 = preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $_POST['choice_1']);
      $choice->choice_2 = preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $_POST['choice_2']);
      $choice->choice_3 = preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $_POST['choice_3']);
      $choice->question_id = $question_id;
      $choice->reference = preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $_POST['reference']) ?: '';
      $choice->save();

      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_0']);
      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_1']);
      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_2']);

      if ($arr_post[0]) {
        $arr = DB::query("SELECT MAX(quiz_num) FROM tag WHERE txt = '".$arr_post[0]."'")->execute()->as_array();
        $quiz_num = $arr[0]['max']+1;
        $sql = "INSERT INTO tag (question_id,txt,open_time,quiz_num) VALUES (".$question_id.",'".$arr_post[0]."','".$open_time."',".$quiz_num.")";
      }
      if ($arr_post[1]) {
        $sql = $sql.",(".$question_id.",'".$arr_post[1]."','".$open_time."',0)";
      }
      if ($arr_post[2]) {
        $sql = $sql.",(".$question_id.",'".$arr_post[2]."','".$open_time."',0)";
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
      
      $myphoto = htmlspecialchars($_POST['myphoto'], ENT_QUOTES);
      $myname = htmlspecialchars($_POST['myname'], ENT_QUOTES);
      
      $txt = htmlspecialchars($_POST['q_txt'], ENT_QUOTES);
      $txt = nl2br($txt);
      $txt = '<a href="/quiz/?q='.$question_id.'" contenteditable="false">'.$txt.'</a>';
      $query = DB::insert('forum');
      $query->set(array(
        'txt' => $txt,
        'usr_id' => $usr_id,
        'update_at' => date("Y-m-d H:i:s"),
        'open_time' => date("Y-m-d H:i:s"),
        'u_img' => $myphoto,
        'u_name' => $myname,
        'no_param' => 1,
      ));
      $query->execute();
      DB::query("UPDATE usr SET forum = forum + 1 WHERE id = ".$usr_id)->execute();
      DB::query("UPDATE usr SET quiz = quiz + 1 WHERE id = ".$usr_id)->execute();
    } catch (Orm\ValidationFailed $e) {
      $res[1] = $e->getMessage();
      Model_Log::warn($res[1]);
      die(json_encode($res));
    }
    $res[0] = 1;
    $res[1] = $question_id;
    die(json_encode($res));
  }
}
