<?php
class Controller_Quiz extends Controller
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
        die(View::forge('404'));
      }
    } else {
      die(View::forge('404'));
    }
    $arr_choice_1 = DB::select()->from('choice')->where('question_id','=',$question_id)->execute()->as_array();
    if ( !isset($arr_choice_1[0]['choice_0']) ) {
      $view = View::forge('404');
      die($view);
    }
    
    $cho_0 = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_choice_1[0]['choice_0']) );
    $cho_1 = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_choice_1[0]['choice_1']) );
    $cho_2 = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_choice_1[0]['choice_2']) );
    $cho_3 = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_choice_1[0]['choice_3']) );
    $random_choice = [$cho_0,$cho_1,$cho_2,$cho_3];

    $descriptive = false;
    if ( isset($_GET['amp']) ) {
      $view = View::forge('quiz_amp');
    } else if (isset($arr_choice_1[0]['choice_1']) AND !$arr_choice_1[0]['choice_1']) {
      $descriptive = true;
      $view = View::forge('quiz');
    } else {
      $view = View::forge('quiz');
    }

    $description = 
      '①'.Str::truncate($random_choice[0], 20)
      .'②'.Str::truncate($random_choice[1], 20)
      .'③'.Str::truncate($random_choice[2], 20)
      .'④'.Str::truncate($random_choice[3], 20);
    $q_txt = Security::htmlentities( preg_replace('/\[|\[|[\t]|\\\/u', ' ', $q_txt) );
    
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
        $arr_comment[$k]['txt'] = nl2br( Security::htmlentities($d['txt']) );
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
    $random_choice[4] = $cho_0;
    $view->arr_choice = $random_choice;
    $view->question = $question_id;
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
    $view->correct = $cho_0;
    $view->description = $description;
    $view->q_txt = nl2br($q_txt);
    $view->title = Str::truncate($q_txt, 32);
    $view->arr_comment = $arr_comment;
    $view->q_data = '';
    $view->reference = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_choice_1[0]['reference']) );
    $view->u_id = Model_Cookie::get_usr();
    $view->descriptive = $descriptive;

    $expires = 3600 * 24;
    header('Last-Modified: Fri Jan 01 2010 00:00:00 GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
    header('Cache-Control: private, max-age=' . $expires);
    header('Pragma: ');

    die($view);
  }
}
