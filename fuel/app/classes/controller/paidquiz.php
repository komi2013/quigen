<?php
class Controller_Paidquiz extends Controller
{
  public function action_index()
  {
    if (isset($_GET['q'])) {
      $arr_pay_q = DB::select()->from('pay_q')->where('id','=',$_GET['q'])->execute()->as_array();
      if (isset($arr_pay_q[0]['id'])) {
        $question_id =  $arr_pay_q[0]['id'];
        $q_txt = $arr_pay_q[0]['txt'];
        $q_img = $arr_pay_q[0]['img'];
      } else {
        $view = View::forge('404');
        
        die($view);
      }
    }
    $pay_choice = DB::select()->from('pay_choice')
      ->where('question_id','=',$question_id)
      ->execute()->as_array();
    
    $random_choice = array(
      Security::htmlentities($pay_choice[0]['choice_0']),
      Security::htmlentities($pay_choice[0]['choice_1']),
      Security::htmlentities($pay_choice[0]['choice_2']),
      Security::htmlentities($pay_choice[0]['choice_3'])
    );
    $arr_answer = json_decode(Cookie::get('answer')) ?: array();
    $already = 0;
    $arr_choice = array();
    $description = '';

    $view = View::forge('paid_quiz');
    if ($already == 1)
    {
      $view = View::forge('paid_quiz_finish');
      $random_choice = $arr_choice;
    }
    $q_txt = Security::htmlentities($q_txt);
    $view->img = $q_img;
    shuffle($random_choice);
    $view->arr_choice = $random_choice;
    $view->question = $question_id;
    $view->correct = $pay_choice[0]['choice_0'];
    $pack = DB::query("select usr_id from pack where id = (select pack_id from pay_q where id =".$question_id.")")
      ->execute()->as_array();
    $view->usr = $pack[0]['usr_id'];
    
    if ($description == '')
    {
      $description = 
        Str::truncate($random_choice[0], 20).', '.
        Str::truncate($random_choice[1], 20).', '.
        Str::truncate($random_choice[2], 20).', '.
        Str::truncate($random_choice[3], 20).', ';
    }  
    $view->description = $description;
    $view->q_txt = $q_txt;
    $view->q_id = $question_id;
    
    die($view);
  }
}
