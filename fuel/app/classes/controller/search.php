<?php
class Controller_Search extends Controller
{
  public function action_index()
  {
    if ( !isset($_GET['tag']) ) {
      Model_Log::warn('no tag');
      die( View::forge('404') );
    }
    $query = DB::select()->from('tag')
      ->where('txt','=',$_GET['tag'])
      ->execute()->as_array();
    $arr_qu_id = [0];
    $cnt = 0;
    $arr_qu = [];
    foreach ($query as $d) {
      $arr_qu_id[] = $d['question_id'];
      $arr_qu[$d['question_id']]['quiz_num'] = $d['quiz_num'];
//      $arr_qu[$d['question_id']]['id'] = 0;
//      $arr_qu[$d['question_id']]['img'] = '';
//      $arr_qu[$d['question_id']]['q_data'] = '';
//      $arr_qu[$d['question_id']]['txt'] = '';
      ++$cnt;
    }
    if ( $cnt < 1 ) {
      Model_Log::warn('no record');
      die( View::forge('404') );
    }
    $no_param = true;
    $limit = 200;
    $amt_page = '';
    $pager_cnt = ceil($cnt/$limit);
    if ( isset($_GET['page']) ) {
      $page = $_GET['page'];
      $amt_page = '｜ページ'.$_GET['page'];
      $offset = ($pager_cnt - $page)*$limit;
      if ($page > 0 && $offset > -1)
      {
        $no_param = false;
      }
    }
      
//    if ( isset($_GET['endTime']) AND is_integer($_GET['endTime']) ) {
//      $end_time = date('Y-m-d H:i:s',$_GET['endTime']);
//    } else {
//      $end_time = date('Y-m-d H:i:s');
//    }
//    var_dump($offset);
    if ($no_param) {
      $query = DB::select()->from('question')
        ->where('id','in',$arr_qu_id)
        ->order_by('open_time','desc')
        ->limit($limit)
        ->execute()->as_array();
      $next_page = $pager_cnt-1;
    } else {
      $query = DB::select()->from('question')
        ->where('id','in',$arr_qu_id)
        ->order_by('open_time','desc')
        ->limit($limit)->offset($offset)
        ->execute()->as_array();
      $next_page = $page-1;
    }

    $left_cnt = 0;
    $description = '';
    foreach ($query as $k => $d) {
      $arr_qu[$d['id']]['id'] = $d['id'];
      $arr_qu[$d['id']]['img'] = $d['img'];
      $arr_qu[$d['id']]['txt'] = Str::truncate(Security::htmlentities($d['txt']), 40);
      $json_arr_q_data = json_encode(array($d['id'],$d['txt'],$d['img'],$d['usr_id']));
      $q_data = Crypt::encode($json_arr_q_data,Config::get('crypt_key.q_data'));
      $arr_qu[$d['id']]['q_data'] = $q_data;
      $open_time = new DateTime($d['open_time']);
      $end_time = $open_time->getTimestamp();
      $description .= Security::htmlentities($d['txt']).'..';
      ++$left_cnt;
    }
    foreach ($arr_qu as $k => $d) {
      if ( isset($d['id']) ) {
        $arr_qu[$k]['txt'] = $d['quiz_num'].'問. '.$d['txt'];
      } else {
        unset($arr_qu[$k]);
      }
    }
    $query = DB::select()->from('mt_seo_tag')
      ->where('tag','=',$_GET['tag'])
      ->execute()->as_array();
    $view = View::forge('search');
    $view->title = $_GET['tag'].$amt_page;
    $view->description = Str::truncate($description, 200);
    $view->noindex = true;
    foreach ($query as $k => $d) {
      if ($no_param) {
        $view->title = $d['title'];
        $view->description = $d['description'];
      }
      $view->noindex = false;
    }
    $view->cnt = $cnt; 
    $view->tag = isset($_GET['tag']) ? $_GET['tag'] : '';
    $view->question = $arr_qu;
    $view->next_page = $next_page;
    $view->left_cnt = $left_cnt;
    $view->limit = $limit;
    return $view;
  }
}
