<?php
class Controller_Sitemap2 extends Controller
{
  public function action_all()
  {
    $slash = explode( '/', $_SERVER['REQUEST_URI'] );
    if ( !isset($slash[2]) ) {
      die( View::forge('404') );
    }
    $arr = DB::query("SELECT * FROM question WHERE id IN ( SELECT question_id FROM tag WHERE txt = '".urldecode( $slash[2] )."') ")->execute()->as_array();
    
    if ( !isset($arr[0]) ) {
      die( View::forge('404') );
    }
    
    foreach ($arr as $k => $d) {
      echo 'http://juken.quigen.info/quiz/?q='.$d['id'].'/';
      echo "\r\n";
    }
    
  
  } 

}