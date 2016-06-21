<?php
class Controller_QuizBuy extends Controller
{
  public function action_index()
  {
    $res[0] = 2;
    if (!is_numeric($_POST['q_id']))
    {
      die(json_encode($res));
    }
    $question_id = $_POST['q_id'];
    $buyer_id = Model_Cookie::get_usr();
    if (!$buyer_id)
    {
      die(json_encode($res));
    }
    
    if ( ! ($_POST['point'] == 0 OR $_POST['point'] == 20) )
    {
      die(json_encode($res));
    }
    $point = $_POST['point'];
    if (!is_numeric($_POST['usr']))
    {
      die(json_encode($res));
    }
    $usr_id = $_POST['usr'];
    try
    {
      $quiz_buy = new Model_QuizBuy();
      $quiz_buy_id = $quiz_buy->get_new_id();
      $quiz_buy->id = $quiz_buy_id;
      $quiz_buy->buyer = $buyer_id;
      $quiz_buy->seller = $usr_id;
      $quiz_buy->point = $point;
      $quiz_buy->question_id = $question_id;
      $quiz_buy->create_at = date("Y-m-d H:i:s");
//      $quiz_buy->q_txt = $_POST['q_txt'];
//      $quiz_buy->q_img = $_POST['q_img'];
      $quiz_buy->save();
      
      $usr = DB::select()->from('usr')
        ->where('id','=',$usr_id)
        ->execute()->as_array();
      if (isset($usr[0]['img']) AND $usr[0]['img']) {
        $usr_img = $usr[0]['img'];
      }else{
        $usr_img = '/assets/img/icon/guest.png';
      }
      $private_news = new Model_PrivateNews();
      $private_news->usr_id = $usr_id;
      $q_img = preg_replace('/http/', 'url', $_POST['q_img']);
      $q_img = $q_img ?: '/assets/img/icon/quiz_generator.png';
      $txt = '<a href="/profile/?u='.$usr_id.'">'.
        '<img src="'.$usr_img.'" class="icon"></a>&nbsp;が'.
        '<a href="/quiz/?q='.$question_id.'"><img src="'.$q_img.'" alt="quiz"></a>の'.
        '<a href="#" onClick="accept('.$quiz_buy_id.')">'.
        'try to buy this quiz with '.$point.' point'.
        '</a>'      
      ;

      $private_news->txt = $txt;
      $private_news->create_at = date("Y-m-d H:i:s");
      $private_news->save();

    }
    catch (Orm\ValidationFailed $e)
    {
      $res[1] = $e->getMessage();
      die(json_encode($res));
    }
    
    $res[0] = 1;
    $res[1] = $point;
    die(json_encode($res));
  }
}
