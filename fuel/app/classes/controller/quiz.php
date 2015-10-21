<?php
class Controller_Quiz extends Controller
{
  public function action_index()
  {
    if (isset($_GET['crypt_q'])) {
      $json_arr_q_data = Crypt::decode($_GET['crypt_q'],Config::get('crypt_key.q_data'));
      $arr_q_data = json_decode($json_arr_q_data);
      if ($arr_q_data) {
        $question_id =  $arr_q_data[0];
        $q_txt = $arr_q_data[1];
        $q_img = $arr_q_data[2];
        $q_u_id = $arr_q_data[3];
      } else {
        $view = View::forge('404');
        
        die($view);
      }
    } else if ( isset($_GET['q']) AND is_numeric($_GET['q']) ) {
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
      Security::htmlentities($arr_choice_1[0]['choice_0']),
      Security::htmlentities($arr_choice_1[0]['choice_1']),
      Security::htmlentities($arr_choice_1[0]['choice_2']),
      Security::htmlentities($arr_choice_1[0]['choice_3'])
    );
    $view = View::forge('quiz');
    $description = 
      '①'.Str::truncate($random_choice[0], 20)
      .'②'.Str::truncate($random_choice[1], 20)
      .'③'.Str::truncate($random_choice[2], 20)
      .'④'.Str::truncate($random_choice[3], 20);
    $q_txt = Security::htmlentities($q_txt);
    
    $query = DB::select()->from('comment')
      ->where('question_id','=',$question_id)
      ->order_by('create_at', 'asc')      
      ->execute()->as_array();
    $arr_comment = [];
    if ( isset($query[0]['id']) ) {
      $arr_u_id = [];
      $util = new Model_Util();
      foreach ($query as $k => $d) {
        $arr_u_id[] = $d['usr_id'];
        $arr_comment[$k]['usr_id'] = $d['usr_id'];
        $arr_comment[$k]['txt'] = Security::htmlentities($d['txt']);
        if ($d['u_img']) {
          $arr_comment[$k]['u_img'] = $d['u_img'];
          $arr_comment[$k]['eto_css'] = '';
        } else {
          $util->eto($d['usr_id']);
          $arr_comment[$k]['u_img'] = $util->eto_img;
          $arr_comment[$k]['eto_css'] = $util->eto_css;
        }
      }
    }
    $view->img = $q_img;
    shuffle($random_choice);
    $view->arr_choice = $random_choice;
    $view->question = $question_id;
    $view->correct = $arr_choice_1[0]['choice_0'];
    $view->usr = $q_u_id;
    $view->fb_url = 'http://www.facebook.com/sharer.php?u=http://'.
        Config::get('my.domain').
        '/quiz/?q='.
        $question_id.'%26cpn=share_fb';
    $view->tw_url = 
        'https://twitter.com/intent/tweet?url=http://'.
        Config::get('my.domain').
        '/quiz/?q='.$question_id.'%26cpn=share_tw'.
        '&text='.
        $q_txt.','.$description.'+@quigen2015';
    $view->ln_url = 'line://msg/text/?'.
        $q_txt.
        '%0D%0Ahttp://'.
        Config::get('my.domain').
        '/quiz/?q='.
        $question_id.'%26cpn=share_ln';
    $view->clip_url = 'http://'.
        Config::get('my.domain').
        '/quiz/?q='.
        $question_id;
    $view->description = $description;
    $view->q_txt = $q_txt;
    $view->arr_comment = $arr_comment;
    $json_arr_q_data = json_encode(array($question_id,$q_txt,$q_img,$q_u_id));
    $q_data = Crypt::encode($json_arr_q_data,Config::get('crypt_key.q_data'));
    $view->q_data = $q_data;
    $view->reference = $arr_choice_1[0]['reference'];
    $view->u_id = Model_Cookie::get_usr();
    die($view);
  }
}
