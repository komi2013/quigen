<?php
class Controller_Quizusrshow extends Controller
{
  public function action_index()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    if( !isset($_GET['q']) OR !is_numeric($_GET['q']) ) {
      Model_Log::warn('no q');
      die(json_encode($res));
    }
    $question = DB::select()->from('question')
      ->where('id','=',$_GET['q'])
      ->execute()->as_array();
    
    $generator_id = $question[0]['usr_id'];  
    $util = new Model_Util();
    $usr = DB::select()->from('usr')
      ->where('id','=',$generator_id)
      ->execute()
      ->as_array();

    if ( isset($usr[0]['id']) ) {
      $arr_generator = array();
      foreach ($usr as $k => $d)
      {
        $arr_generator[0] = $d['id'];
        $arr_generator[1] = $d['name'];
        $arr_generator[2] = $d['img'];
        $arr_generator[3] = '';
      }
    } else {
      $util->eto($generator_id);
      $arr_generator[0] = $generator_id;
      $arr_generator[1] = $util->eto_txt;
      $arr_generator[2] = $util->eto_img;
      $arr_generator[3] = $util->eto_css;
    }
    $arr_answer_key_q = DB::select()->from('answer_key_q')
      ->where('question_id','=',$_GET['q'])
      ->order_by('create_at','desc')
      ->limit(100)
      ->execute()->as_array();

    $arr_correct = []; $arr_incorrect = []; $correct_i = 0; $incorrect_i = 0;
    foreach ($arr_answer_key_q as $k => $d)
    {
      if ( $d['u_img'] ) {
        $u_img = strip_tags( preg_replace('/http/', 'url', $d['u_img']) );
        $css   = '';
      } else {
        $util->eto($d['usr_id']);
        $u_img = $util->eto_img;
        $css   = $util->eto_css;
      }

      if ($d['result'] == 1)
      {
        if ($correct_i < 16) {
          $arr_correct[$correct_i][0] = $d['usr_id'];
          $arr_correct[$correct_i][1] = '';
          $arr_correct[$correct_i][2] = $u_img;
          $arr_correct[$correct_i][3] = 0;
          $arr_correct[$correct_i][4] = $css;
          ++$correct_i;
        }
      }
      else
      {
        if ($incorrect_i < 16) {
          $arr_incorrect[$incorrect_i][0] = $d['usr_id'];
          $arr_incorrect[$incorrect_i][1] = '';
          $arr_incorrect[$incorrect_i][2] = $u_img;
          $arr_incorrect[$incorrect_i][3] = 0;
          $arr_incorrect[$incorrect_i][4] = $css;
          ++$incorrect_i;
        }
      }
    }

    $res[0] = 1;
    $res[1] = $arr_generator;
    $res[2] = $arr_correct;
    $res[3] = $arr_incorrect;
    die(json_encode($res));
    
// 		return Response::forge(View::forge('welcome/index'));
  }
}
