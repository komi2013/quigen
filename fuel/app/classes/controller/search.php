<?php
class Controller_Search extends Controller
{
  public function action_index()
  {
    if (!isset($_GET['tag']))
    {
      Model_Log::warn('no tag');
      die( View::forge('404') );
    }
    $query = DB::select()->from('tag')
      ->where('txt','=',$_GET['tag'])
      ->execute()->as_array();
    $arr_qu_id = [0];
    $cnt = 0;
    foreach ($query as $d)
    {
      $arr_qu_id[] = $d['question_id'];
      ++$cnt;
    }
    $query = DB::select()->from('question')
      ->where('id','in',$arr_qu_id)
      ->order_by('open_time','desc')
      ->limit(200)
      ->execute()->as_array();

    $arr_qu = [];
    foreach ($query as $k => $d) {
      $arr_qu[$d['id']]['id'] = $d['id'];
      $arr_qu[$d['id']]['img'] = $d['img'];
      $arr_qu[$d['id']]['txt'] = $d['txt'];
      $json_arr_q_data = json_encode(array($d['id'],$d['txt'],$d['img'],$d['usr_id']));
      $q_data = Crypt::encode($json_arr_q_data,Config::get('crypt_key.q_data'));
      $arr_qu[$d['id']]['q_data'] = $q_data;
      $open_time = new DateTime($d['open_time']);
      $end_time = $open_time->getTimestamp();
    }
    $query = DB::select()->from('mt_seo_tag')
      ->where('tag','=',$_GET['tag'])
      ->execute()->as_array();
    $view = View::forge('search');
    $view->title = $_GET['tag'];
    $view->description = $_GET['tag'].'の一覧';
    $view->noindex = true;
    foreach ($query as $k => $d) {
      $view->title = $d['title'];
      $view->description = $d['description'];
      $view->noindex = false;
    }
    $view->tag = isset($_GET['tag'])? $_GET['tag'] : '';
    $view->question = $arr_qu;
    $view->end_time = $end_time;
    return $view;
  }
}
