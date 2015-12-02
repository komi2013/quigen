<?php
class Controller_Sitemap extends Controller
{
  public function action_dynamic()
  {
    if ( !$this->param('tag') ) {
      die( View::forge('404') );
    }
    $arr = DB::query("SELECT * FROM question WHERE id IN ( SELECT question_id FROM tag WHERE txt = '".$this->param('tag')."') ")->execute()->as_array();
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

}