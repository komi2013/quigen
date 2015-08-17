<?php
class Controller_Top extends Controller
{
  public function action_index()
  {
    $view = View::forge('top');
    $res = DB::query("select count(*) from question where open_time < '2115-01-01'")
      ->execute()->as_array();
    $this->cnt = ceil($res[0]['count']/20);
    if (isset($_GET['page']))
    {
      $page = $_GET['page'];
      $view->page = $page;
      $offset = ($this->cnt - $page)*20;
      if ($page > 1 && $offset > -1)
      {
        $question = DB::select()->from('question')
          ->where('open_time','<',date('Y-m-d H:i:s'))
          ->order_by('open_time', 'desc')
          ->limit(20)->offset($offset)
          ->execute()->as_array();
        foreach ($question as $d)
        {
          $arr_qu[$d['id']]['id'] = $d['id'];
          $arr_qu[$d['id']]['img'] = $d['img'];
          $arr_qu[$d['id']]['txt'] = $d['txt'];
          $json_arr_q_data = json_encode(array($d['id'],$d['txt'],$d['img'],$d['usr_id']));
          $q_data = Crypt::encode($json_arr_q_data,Config::get('crypt_key.q_data'));
          $arr_qu[$d['id']]['q_data'] = $q_data;
        }
        $view->question = $arr_qu;
        
        die($view);
      }
      else
      {
        $this->popular_quiz();
      }
    }
    else
    {
      $this->popular_quiz();
    }
  }
  public function popular_quiz()
  {
    $view = View::forge('top');
    $query = DB::query("SELECT question_id FROM answer_by_q WHERE update_at < NOW() ORDER BY".
            "(30 - EXTRACT( DAY FROM(NOW() - update_at) )) * amount DESC
            LIMIT 20 ")->execute()->as_array();
    $arr_qu_id = array();
    $arr_qu = array();
    foreach ($query as $d)
    {
      $arr_qu_id[] = $d['question_id'];
      $arr_qu[$d['question_id']]['id'] = $d['question_id'];
      $arr_qu[$d['question_id']]['img'] = '';
      $arr_qu[$d['question_id']]['txt'] = 'not exist';
      $arr_qu[$d['question_id']]['q_data'] = '';
    }
    $question = DB::select()->from('question')
        ->where('id','in',$arr_qu_id)
        ->and_where('open_time','<',date('Y-m-d H:i:s'))
        ->execute()->as_array();
    foreach ($question as $d)
    {
      $arr_qu[$d['id']]['id'] = $d['id'];
      $arr_qu[$d['id']]['img'] = $d['img'];
      $arr_qu[$d['id']]['txt'] = $d['txt'];
      $json_arr_q_data = json_encode(array($d['id'],$d['txt'],$d['img'],$d['usr_id']));
      $q_data = Crypt::encode($json_arr_q_data,Config::get('crypt_key.q_data'));
      $arr_qu[$d['id']]['q_data'] = $q_data;
    }
    $view->question = $arr_qu;
    $view->page = $this->cnt+1;
    $view->popular = true;
    
    die($view);    
  }
}
