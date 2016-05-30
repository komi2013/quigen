<?php
class Controller_QuizEdit extends Controller
{
  public function action_index()
  {
    if ( isset($_GET['q']) AND is_numeric($_GET['q']) ) {
      $arr_question = DB::select()->from('question')->where('id','=',$_GET['q'])->execute()->as_array();
      if ( isset($arr_question[0]['id']) ) {
        $question_id =  $arr_question[0]['id'];
        $q_txt = $arr_question[0]['txt'];
        $q_img = $arr_question[0]['img'];
        $q_u_id = $arr_question[0]['usr_id'];
      } else {
        $view = View::forge('404');
        
        die($view);
      }
    } else {
      $view = View::forge('404');
      die($view);
    }
    $arr_choice_1 = DB::select()->from('choice')->where('question_id','=',$question_id)->execute()->as_array();
    if ( !isset($arr_choice_1[0]['choice_0']) ) {
      $view = View::forge('404');
      
      die($view);
    }

    $random_choice = array(
      Security::htmlentities( preg_replace('/[\n\r\t]/', '　', $arr_choice_1[0]['choice_0']) ),
      Security::htmlentities( preg_replace('/[\n\r\t]/', '　', $arr_choice_1[0]['choice_1']) ),
      Security::htmlentities( preg_replace('/[\n\r\t]/', '　', $arr_choice_1[0]['choice_2']) ),
      Security::htmlentities( preg_replace('/[\n\r\t]/', '　', $arr_choice_1[0]['choice_3']) )
    );
    $view = View::forge('quiz_edit');
    $q_txt = Security::htmlentities( preg_replace('/[\t]/', '　', $q_txt) );
    $view->img = $q_img;
    $view->arr_choice = $random_choice;
    $view->question = $question_id;
    $view->correct = Security::htmlentities( preg_replace('/[\n\r\t]/', '　', $arr_choice_1[0]['choice_0']) );
    $view->usr = $q_u_id;
    $view->q_txt = $q_txt;
    $json_arr_q_data = json_encode(array($question_id,$q_txt,$q_img,$q_u_id));
    $q_data = Crypt::encode($json_arr_q_data,Config::get('crypt_key.q_data'));
    $view->q_data = $q_data;
    $view->reference = $arr_choice_1[0]['reference'];
    $view->open_time = $arr_question[0]['open_time'];
    $view->u_id = Model_Cookie::get_usr();
    die($view);
  }
}
