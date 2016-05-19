<?php
class Controller_Top extends Controller
{
  public function action_index()
  {
    $expires = 3600 * 24;
    header('Last-Modified: Fri Jan 01 2010 00:00:00 GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
    header('Cache-Control: private, max-age=' . $expires);
    header('Pragma: ');
    $view = View::forge('top');
    $res = DB::query("select count(*) from question where open_time < '2115-01-01'")
      ->execute()->as_array();
    $this->cnt = ceil($res[0]['count']/200);
    $query = DB::query("SELECT txt FROM tag GROUP BY txt")->execute()->as_array();
    $arr_tag = [];
    foreach($query as $k => $d){
      $arr_tag[$k]['url_txt'] = urlencode($d['txt']);
      $arr_tag[$k]['txt'] = Str::truncate(Security::htmlentities($d['txt']), 40);
    }
    $this->arr_tag = $arr_tag;
    if ( isset($_GET['page']) ) {
      $page = $_GET['page'];
      $view->page = $page;
      $offset = ($this->cnt - $page)*200;
      if ($page > 1 && $offset > -1) {
        $question = DB::select()->from('question')
          ->where('open_time','<',date('Y-m-d H:i:s'))
          ->order_by('open_time', 'desc')
          ->limit(200)->offset($offset)
          ->execute()->as_array();
        foreach ($question as $d) {
          $arr_qu[$d['id']]['id'] = $d['id'];
          $arr_qu[$d['id']]['img'] = $d['img'];
          $arr_qu[$d['id']]['txt'] = Str::truncate(Security::htmlentities($d['txt']), 40);
          $arr_qu[$d['id']]['tag'] = '';
        }
        $view->question = $arr_qu;
        $view->exactly_top = false;
        $view->arr_tag = $this->arr_tag;
        die($view);
      } else {
        $this->tag_quiz();
      }
    }
    else
    {
      $this->tag_quiz();
    }
  }
//  public function popular_quiz()
//  {
//    $view = View::forge('top');
//    $query = DB::query("SELECT question_id, amount FROM answer_by_q WHERE update_at < NOW() ORDER BY".
//            "(30 - EXTRACT( DAY FROM(NOW() - update_at) )) * amount DESC
//            LIMIT 20 ")->execute()->as_array();
//    $arr_qu_id = [];
//    $arr_qu = [];
//    foreach ($query as $d)
//    {
//      $arr_qu_id[] = $d['question_id'];
//      $arr_qu[$d['question_id']]['id'] = $d['question_id'];
//      $arr_qu[$d['question_id']]['img'] = '';
//      $arr_qu[$d['question_id']]['txt'] = 'not exist';
//      $arr_qu[$d['question_id']]['a_amount'] = $d['amount'];;
//    }
//    $question = DB::select()->from('question')
//        ->where('id','in',$arr_qu_id)
//        ->and_where('open_time','<',date('Y-m-d H:i:s'))
//        ->execute()->as_array();
//    foreach ($question as $d)
//    {
//      $arr_qu[$d['id']]['id'] = $d['id'];
//      $arr_qu[$d['id']]['img'] = $d['img'];
//      $arr_qu[$d['id']]['txt'] = Str::truncate(Security::htmlentities($d['txt']), 30);
//    }
//    $view->question = $arr_qu;
//    $view->page = $this->cnt+1;
//    $view->popular = true;
//    
//    die($view);    
//  }
  public function tag_quiz()
  {
    $view = View::forge('top');
    $arr = DB::query("SELECT * FROM mt_tag_top ORDER BY seq")->execute()->as_array();
    $arr_qu = [];
    foreach ($arr as $k => $d) {
      $arr_qu[$d['question_id']]['id'] = $d['question_id'];
      $arr_qu[$d['question_id']]['img'] = $d['img'];
      //$txt = Security::htmlentities($d['txt']);
      $arr_qu[$d['question_id']]['txt'] = Str::truncate(Security::htmlentities($d['txt']), 40);
      $arr_qu[$d['question_id']]['tag'] = $d['tag'];
    }
    $view->question = $arr_qu;
    $view->page = $this->cnt+1;
    $view->exactly_top = true;
    $view->arr_tag = $this->arr_tag;
    die($view);
  }

}
