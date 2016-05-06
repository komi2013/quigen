<?php
class Controller_Answer extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    //Model_Csrf::check();
    if (!isset($_POST['question']) OR !is_numeric($_POST['question'])) {
      Model_Log::warn('no question');
      die(json_encode($res));
    }
    $question_id = $_POST['question'];
    $usr_id = Model_Cookie::get_usr('u_id');
    if (!$usr_id) {
      $usr = new Model_Usr();
      $usr_id = $usr->get_new_id();
      Model_Cookie::set_usr($usr_id);
      Cookie::set('ua_u_id',$usr_id);
    }
    try {
      $answer_by_q = Model_AnswerByQ::find('first', array(
        'where' => array(
          array('question_id', $question_id),
        ),
      ));
      if ($_POST['correct'] == 1) {
        $answer_by_q->correct++;
      }
      $answer_by_q->update_at = date("Y-m-d H:i:s");
      $answer_by_q->amount++;
      $answer_by_q->save();

      if ($_POST['correct'] == 1) {
        if(isset($_POST['arr_tag'][0])){
          $sql_value = 'INSERT INTO tag_rank (usr_id,tag,create_at,u_img,u_name) VALUES ';
          if(isset($_POST['arr_tag'][0])){
            $without_hash = preg_replace('/#/u', '', $_POST['arr_tag'][0]);
            $secure_tag = preg_replace('/\W+/u', '_', $without_hash);
            $secure_u_img = str_replace("'", "", $_POST['u_img']);
            $secure_u_name = str_replace("'", "", $_POST['u_name']);
            $sql_value = $sql_value."(".$usr_id.",'".$secure_tag."','".date('Y-m-d H:i:s')."','".$secure_u_img."','".$secure_u_name."')";
          }
          if(isset($_POST['arr_tag'][1])){
            $without_hash = preg_replace('/#/u', '', $_POST['arr_tag'][1]);
            $secure_tag = preg_replace('/\W+/u', '_', $without_hash);
            $secure_u_img = str_replace("'", "", $_POST['u_img']);
            $secure_u_name = str_replace("'", "", $_POST['u_name']);
            $sql_value = $sql_value.",(".$usr_id.",'".$secure_tag."','".date('Y-m-d H:i:s')."','".$secure_u_img."','".$secure_u_name."')";
          }
          if(isset($_POST['arr_tag'][2])){
            $without_hash = preg_replace('/#/u', '', $_POST['arr_tag'][2]);
            $secure_tag = preg_replace('/\W+/u', '_', $without_hash);
            $secure_u_img = str_replace("'", "", $_POST['u_img']);
            $secure_u_name = str_replace("'", "", $_POST['u_name']);
            $sql_value = $sql_value.",(".$usr_id.",'".$secure_tag."','".date('Y-m-d H:i:s')."','".$secure_u_img."','".$secure_u_name."')";
          }
          DB::query($sql_value)->execute();
        }
      }
      $answer_key_u = new Model_AnswerKeyU();
      $answer_key_u->usr_id = $usr_id;
      $answer_key_u->question_id = $question_id;
      $answer_key_u->result = $_POST['correct'];
      $q_txt = preg_replace('/\n|\r|\r\n/', '', $_POST['q_txt']);
      $answer_key_u->q_txt = preg_replace('/\t/', '　', $q_txt);
      $answer_key_u->q_img = $_POST['q_img'];
      $answer_key_u->create_at = date( "Y-m-d H:i:s" );
      $answer_key_u->save();
      
      $answer_key_q = new Model_AnswerKeyQ();
      $answer_key_q->usr_id = $usr_id;
      $answer_key_q->question_id = $question_id;
      $answer_key_q->result = $_POST['correct'];
      $answer_key_q->u_img = $_POST['u_img'];
      $answer_key_q->create_at = date( "Y-m-d H:i:s" );
      $answer_key_q->save();
      
      $a_news_time = new Model_ANewsTime();
      $a_news_time->following_u_id = $usr_id;
      $a_news_time->question_id = $question_id;
      $a_news_time->q_img = $_POST['q_img'];
      $a_news_time->u_img = $_POST['u_img'];
      $a_news_time->create_at = date( "Y-m-d H:i:s" );
      $a_news_time->generator = $_POST['generator'];
      $a_news_time->save();
    }
    catch (Orm\ValidationFailed $e) {
      $res[1] = $e->getMessage();
      Model_Log::warn('orm err');
      die(json_encode($res));
    }
    $res[0] = 1;
    die(json_encode($res));
  }
}
