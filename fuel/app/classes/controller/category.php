<?php
class Controller_Category extends Controller
{
  public function action_index()
  {
    if ( !isset($_GET['tag']) ) {
      $view = View::forge('category');
      $query = DB::query("SELECT txt FROM tag GROUP BY txt")->execute()->as_array();
      $meta_description = 'カテゴリ一覧';
      $arr_tag = [];
      foreach($query as $k => $d){
        $meta_description .= ','.Security::htmlentities($d['txt']);
        $arr_tag[$k]['url_txt'] = urlencode($d['txt']);
        $arr_tag[$k]['txt'] = Str::truncate(Security::htmlentities($d['txt']), 30);
      }
      $view->meta_description = $meta_description;
      $view->arr_tag = $arr_tag;
      die($view);
    }
    // tag should be filtered by time
    $query = DB::select()->from('tag')
      ->where('txt','=',$_GET['tag'])
      ->execute()->as_array();
    $arr_qu_id = array(0);
    foreach ($query as $d)
    {
      $arr_qu_id[] = $d['question_id'];
    }
    $query = DB::select()->from('question')
      ->where('id','in',$arr_qu_id)
      ->and_where('open_time','<',date("Y-m-d H:i:s",strtotime("+100 year")))
      ->order_by('id','asc')
      ->limit(100)
      ->execute()->as_array();
    $arr_qu = [];
    foreach ($query as $k => $d)
    {
      $arr_qu[$d['id']]['id'] = $d['id'];
      $arr_qu[$d['id']]['img'] = $d['img'];
      $arr_qu[$d['id']]['txt'] = Str::truncate(Security::htmlentities($d['txt']), 30);
      $json_arr_q_data = json_encode(array($d['id'],$d['txt'],$d['img'],$d['usr_id']));
      $q_data = Crypt::encode($json_arr_q_data,Config::get('crypt_key.q_data'));
      $arr_qu[$d['id']]['q_data'] = $q_data;
    }
    
    $view = View::forge('category_tag');
    $view->question = $arr_qu;

    $meta_description = $_GET['tag'].'一覧';
    foreach($arr_qu as $k => $d){
      $meta_description .= ','.Str::truncate(Security::htmlentities($d['txt']), 30);
    }
    $query = DB::select()->from('mt_seo_tag')
      ->where('tag','=',$_GET['tag'])
      ->execute()->as_array();
    $title = $_GET['tag'];
    $seo = false;
    $meta_robots = '<meta name="robots" content="noindex,follow">';
    foreach ($query as $d) {
      $title = $d['title'];
      $meta_description = $d['description'];
      $meta_robots = '<meta name="robots" content="index,follow">';
      $seo = true;
    }
    $view->title = $title;
    $view->meta_description = $meta_description;
    $view->seo = $seo;
    die($view);    
  }
}
