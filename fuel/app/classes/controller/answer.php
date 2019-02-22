<?php
class Controller_Answer extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    //Model_Csrf::check();
    if (!isset($_POST['question']) OR !is_numeric($_POST['question'])) {
      die( View::forge('404') );
    }
    $question_id = $_POST['question'];
    $usr_id = Model_Cookie::get_usr('u_id');
    if (!$usr_id) {
      $usr = new Model_Usr();
      $usr_id = $usr->get_new_id();
      Model_Cookie::set_usr($usr_id);
      Cookie::set('ua_u_id',$usr_id);
    }
    $query = DB::select()->from('answer_key_q')->where('question_id','=',$question_id)->limit(50)->execute()->as_array();
    $correct_cnt = 0;
    $incorrect_cnt = 0;
    $duplicated_ip = false;
    foreach ($query as $d) {
        if ($d['result']) {
            ++$correct_cnt; 
        } else {
            ++$incorrect_cnt;
        }
        if ($d['ip_address'] == $_SERVER["REMOTE_ADDR"]) {
            $duplicated_ip = true;
        }
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
            $sql_value = $sql_value."(".$usr_id.",'".$without_hash."','".date('Y-m-d H:i:s')."','".$_POST['u_img']."','".$_POST['u_name']."')";
          }
          DB::query($sql_value)->execute();
        }
      }

      $q_txt = preg_replace('/\n|\r|\r\n/', '', $_POST['q_txt']);
      $comment = preg_replace('/\n|\r|\r\n/', '', $_POST['comment']);
      $query = DB::insert('answer_key_u');
      $query->set(array(
        'usr_id' => $usr_id,
        'question_id' => $question_id,
        'result' => $_POST['correct'],
        'q_txt' => $q_txt,
        'q_img' => $_POST['q_img'],
        'create_at' => date("Y-m-d H:i:s"),
        'choice_0' => isset($_POST['choice_0']) ?: '',
        'choice_1' => isset($_POST['choice_1']) ?: '',
        'choice_2' => isset($_POST['choice_2']) ?: '',
        'choice_3' => isset($_POST['choice_3']) ?: '',
        'comment' => preg_replace('/\t/', '　', $comment),
        'myanswer' => $_POST['myanswer'],
        'correct_choice' => $_POST['correct_choice'],
        'quiz_num' => $_POST['quiz_num'],
      ));
      $query->execute();
      
      $query = DB::insert('answer_key_q');
      $query->set(array(
        'usr_id' => $usr_id,
        'question_id' => $question_id,
        'result' => $_POST['correct'],
        'u_img' => $_POST['u_img'],
        'create_at' => date("Y-m-d H:i:s"),
        'ip_address' => $_SERVER["REMOTE_ADDR"],
      ));
      $query->execute();
      
      if ($correct_cnt < 20 AND $incorrect_cnt < 20 AND is_numeric($_POST['generator']) AND !$duplicated_ip) {
        $query = DB::insert('a_news_time');
        $query->set(array(
          'following_u_id' => $usr_id,
          'question_id' => $question_id,
          'q_img' => $_POST['q_img'],
          'u_img' => $_POST['u_img'],
          'create_at' => date("Y-m-d H:i:s"),
          'generator' => $_POST['generator'],
        ));
        $query->execute();
        DB::query("UPDATE usr SET point = point + 1 WHERE id = ".$_POST['generator'])->execute();
      }
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
