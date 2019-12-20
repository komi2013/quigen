<?php
class Controller_Quiz extends Controller
{
  public function action_index()
  {
    if ( isset($_GET['q']) AND is_numeric($_GET['q']) AND strlen( $_GET['q'] ) < 20 ) {
      $sql = "select question.* , choice.* 
                ,c.txt as c_txt,c.usr_id as c_usr_id,c.u_img as c_u_img
                from question
               inner join choice on  choice.question_id = question.id
               left join comment c on question.id = c.question_id
               where question.id = :id";
      $arr_q = DB::query($sql)->bind('id', $_GET['q'])->execute()->as_array();
      
      if ( isset($arr_q[0]['id']) ) {
        $question_id =  $arr_q[0]['id'];
        $q_txt = $arr_q[0]['txt'];
        $q_img = $arr_q[0]['img'];
        $q_u_id = $arr_q[0]['usr_id'];
      } else {
        die(View::forge('404'));
      }
    } else {
      die(View::forge('404'));
    }
    if ( !isset($arr_q[0]['choice_0']) ) {
      $view = View::forge('404');
      die($view);
    }
    $cho_0 = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_q[0]['choice_0']) );
    $cho_1 = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_q[0]['choice_1']) );
    $cho_2 = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_q[0]['choice_2']) );
    $cho_3 = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_q[0]['choice_3']) );
    $random_choice = [$cho_0,$cho_1,$cho_2,$cho_3];

    $view = View::forge('quiz');
    if ( isset($_GET['amp']) ) {
      $view = View::forge('quiz_amp');
    }

    $description = 
      '①'.Str::truncate($random_choice[0], 20)
      .'②'.Str::truncate($random_choice[1], 20)
      .'③'.Str::truncate($random_choice[2], 20)
      .'④'.Str::truncate($random_choice[3], 20);
    $q_txt = Security::htmlentities( preg_replace('/\[|\[|[\t]|\\\/u', ' ', $q_txt) );
    
    $arr_comment = [];
    if ( isset($arr_q[0]['id']) ) {
      $arr_u_id = [];
      $util = new Model_Util();
      foreach ($arr_q as $k => $d) {
        $arr_u_id[] = $d['c_usr_id'];
        $arr_comment[$k]['usr_id'] = $d['c_usr_id'];
        $arr_comment[$k]['txt'] = nl2br(htmlspecialchars($d['c_txt']) );
        if ($d['c_u_img']) {
          $arr_comment[$k]['u_img'] = $d['c_u_img'];
          $arr_comment[$k]['eto_css'] = '';
        } else {
          $util->eto($d['c_usr_id']);
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
    $view->fb_url = 'https://www.facebook.com/sharer.php?u=https://'.
        Config::get('my.domain').
        '/quiz/?q='.
        $question_id.'%26cpn=share_fb';
    $view->tw_url = 
        'https://twitter.com/intent/tweet?url=https://'.
        Config::get('my.domain').
        '/quiz/?q='.$question_id.'%26cpn=share_tw'.
        '&text='.
        $q_txt.','.$description.'+@quigen2015';
    $view->ln_url = 'line://msg/text/?'.
        $q_txt.
        '%0D%0Ahttps://'.
        Config::get('my.domain').
        '/quiz/?q='.
        $question_id.'%26cpn=share_ln';
    $view->clip_url = 'https://'.
        Config::get('my.domain').
        '/quiz/?q='.
        $question_id;
    $view->correct = $cho_0;
    $view->description = $description;
    $view->q_txt = nl2br($q_txt);
    $view->title = Str::truncate($q_txt, 32);
    $view->arr_comment = $arr_comment;
    $view->q_data = '';
    $view->reference = Security::htmlentities( preg_replace('/\[|\[|[\n\r\t]|\\\/u', ' ', $arr_q[0]['reference']) );
    $view->question_type = $arr_q[0]['question_type'];
    $view->sound = $arr_q[0]['sound'];
    $view->u_id = Model_Cookie::get_usr();

    $expires = 3600 * 24;
    header('Last-Modified: Fri Jan 01 2010 00:00:00 GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
    header('Cache-Control: private, max-age=' . $expires);
    header('Pragma: ');

    die($view);
  }
}