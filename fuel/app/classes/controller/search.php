<?php
class Controller_Search extends Controller
{
  public function action_index()
  {
    if ( !isset($_GET['tag']) ) {
      die( View::forge('404') );
    }
    $query = DB::select()->from('tag')
      ->where('txt','=',$_GET['tag'])
      ->and_where( 'open_time','<',date("Y-m-d H:i:s") )
      ->execute()->as_array();
    $arr_qu_id = [0];
    $cnt = 0;
    $arr_qu = [];
    foreach ($query as $d) {
      $arr_qu_id[] = $d['question_id'];
      $arr_qu[$d['question_id']]['quiz_num'] = $d['quiz_num'];
      ++$cnt;
    }
    if ( $cnt < 1 ) {
      die( View::forge('404') );
    }
    $no_param = true;
    $limit = 200;
    $amt_page = '';
    $pager_cnt = ceil($cnt/$limit);
    if ( isset($_GET['page']) ) {
      $page = $_GET['page'];
      $amt_page = ' page'.$_GET['page'];
      $offset = ($pager_cnt - $page)*$limit;
      if ($page > 0 && $offset > -1)
      {
        $no_param = false;
      }
    }
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
      $arr_qu[$d['id']]['q_data'] = '';
      $open_time = new DateTime($d['open_time']);
      $end_time = $open_time->getTimestamp();
      $description .= Security::htmlentities($d['txt']).'..';
      ++$left_cnt;
    }
    foreach ($arr_qu as $k => $d) {
      if ( isset($d['id']) ) {
        $arr_qu[$k]['txt'] = 'No.'.$d['quiz_num'].$d['txt'];
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
    $arr_hreflang = [];
    foreach ($query as $k => $d) {
      if ($no_param) {
        $view->title = $d['title'];
        $view->description = $d['description'];
      }
      $view->noindex = false;
    }
    $query = DB::select()->from('mt_seo_tag')->execute()->as_array();
    $i = 0;
    foreach ($query as $k => $d) {
      if ($d['code'] AND $d['tag'] != $_GET['tag']) {
        $arr_hreflang[$i]['code'] = $d['code'];
        $arr_hreflang[$i]['tag'] = urlencode($d['tag']);
        ++$i;
      }
    }
    arsort($arr_qu);
    $view->arr_hreflang = $arr_hreflang; 
    $view->cnt = $cnt; 
    $view->tag = isset($_GET['tag']) ? $_GET['tag'] : '';
    $view->question = $arr_qu;
    $view->next_page = $next_page;
    $view->left_cnt = $left_cnt;
    $view->limit = $limit;
    return $view;
  }
}
