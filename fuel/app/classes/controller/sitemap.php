<?php
class Controller_Sitemap extends Controller
{
  public function action_dynamic()
  {
    if ( !$this->param('tag') ) {
      die( View::forge('404') );
    }
    $tag = urldecode(explode("/",$_SERVER['REQUEST_URI'])[3]);
    $sql = "SELECT * FROM question WHERE id IN ( "
            ." SELECT question_id FROM tag WHERE txt = '".$tag."') "
            ." AND open_time < '2110-01-01 00:00:01'";
    $arr = DB::query($sql)->execute()->as_array();
    foreach ($arr as $k => $d) {
      echo 'http://'.Config::get("my.domain").'/quiz/?q='.$d['id'];
      echo "\r\n";
    }
  }
  public function action_search()
  {
    $arr = DB::query("SELECT * FROM mt_seo_tag")->execute()->as_array();
    foreach ($arr as $k => $d) {
      echo 'http://'.Config::get("my.domain").'/search/?tag='.$d['tag'];
      echo "\r\n";
    }
  }
  public function action_static()
  {
      echo 'http://'.Config::get("my.domain").'/generate/'."\r\n";
      echo 'http://'.Config::get("my.domain").'/htm/rule/'."\r\n";
      echo 'http://'.Config::get("my.domain").'/htm/quest/'."\r\n";
      echo 'http://'.Config::get("my.domain").'/forumlist/'."\r\n";
      
  }

}