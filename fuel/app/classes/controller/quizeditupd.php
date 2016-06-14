<?php
class Controller_QuizEditUpd extends Controller
{
  public function action_index()
  {
    $usr_id = Model_Cookie::get_usr();
    $auth = false;
    foreach (Config::get('my.adm') as $d) {
      if ($d == $usr_id) {
        $auth = true;
      }
    }
    $query = DB::select()->from('question')
      ->where('id','=',$_POST['q_id'])
      ->execute()->as_array();
    
    if ($query[0]['usr_id'] == $usr_id) {
      $auth = true;
    }
    if (!$auth AND $_SERVER['REMOTE_ADDR'] != '133.242.146.131') {
      $view = View::forge('404');
      die($view);
    }
    $res[0] = 2;
    Model_Csrf::check();

    $query = DB::select()->from('mt_block_generate')
      ->where('usr_id','=',$usr_id)
      ->execute()->as_array();
    if (isset($query[0])) {
      Model_Log::warn('blocked');
      die(json_encode($res));
    }
    $question_id = $_POST['q_id'];
    $arr_question = DB::select()->from('question')
      ->where('id','=',$question_id)
      ->execute()->as_array();

    if ($_POST["img"] == 'no') {
      $web_path = '';
    } else {
      @mkdir(DOCROOT.'assets/img/quiz/'.date('Ymd',strtotime($arr_question[0]['create_at'])), 0777);
      @chmod(DOCROOT.'assets/img/quiz/'.date('Ymd',strtotime($arr_question[0]['create_at'])), 0777);
      $img_path = DOCROOT.'assets/img/quiz/'.date('Ymd',strtotime($arr_question[0]['create_at'])).'/'.$question_id.'.png';
      $web_path = '/assets/img/quiz/'.date('Ymd',strtotime($arr_question[0]['create_at'])).'/'.$question_id.'.png';
      $canvas = $_POST["img"];
      $canvas = preg_replace("/data:[^,]+,/i","",$canvas);
      $canvas = base64_decode($canvas);
      $image = imagecreatefromstring($canvas);
      imagesavealpha($image, TRUE);
      imagepng($image ,$img_path);
    }
    try {
      DB::update('question')
        ->value("txt",$_POST['q_txt'])
        ->value("create_at",date("Y-m-d H:i:s"))
        ->value("img",$web_path)
        ->value("open_time",$arr_question[0]['open_time'])
        ->where('id','=',$question_id)
        ->execute();

      DB::update('choice')
        ->value("choice_0",$_POST['choice_0'])
        ->value("choice_1",$_POST['choice_1'])
        ->value("choice_2",$_POST['choice_2'])
        ->value("choice_3",$_POST['choice_3'])
        ->value("reference",$_POST['reference'])
        ->where('question_id','=',$question_id)
        ->execute();

      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_0']);
      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_1']);
      $arr_post[] = preg_replace('/\W+/u', '_', $_POST['tag_2']);
      if ($arr_post[0]) {
        $query = DB::update('tag')->value("txt",$arr_post[0])->where('question_id','=',$question_id)->execute();
        if ($query < 1) {
          $query = DB::select()->from('question')->where('id','=',$question_id)->execute()->as_array();
          $sql = "INSERT INTO tag (question_id,txt,open_time) VALUES (".$question_id.",'".$arr_post[0]."','".$query[0]["open_time"]."')";
          DB::query($sql)->execute();
        }
      }
    } catch (Orm\ValidationFailed $e) {
      $res[1] = $e->getMessage();
      Model_Log::warn('orm err');
      die(json_encode($res));
    }
    $res[0] = 1;
    $res[1] = '';
    die(json_encode($res));
  }
}
