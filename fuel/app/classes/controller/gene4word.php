<?php
class Controller_Gene4word extends Controller
{
  public function action_index()
  {
    $usr_id = Model_Cookie::get_usr();
//    $query = DB::select()->from('question')
//      ->where('usr_id','=',$usr_id)
//      ->order_by('open_time', 'desc')
//      ->execute()->as_array();
//    $now = new DateTime("now");
//    if ( isset($query[0]['open_time']) ) {
//      $available = new DateTime($query[0]['open_time']);
//      $now_limit = new DateTime("now");
//      $now_limit->add( new DateInterval('P14D') );
//      
//      if ( $query[0]['open_time'] > "2100-01-01 00:00:00" ) {
//        $available->sub( new DateInterval('P100Y') );
//      }
//      
//      if ($now_limit < $available) {
//        $available->sub( new DateInterval('P14D') );
//        $view = View::forge('generate_limited');
//        $view->available = $available->format('Y-m-d H:i:s');
//        
//        die($view);
//      }
//    }
    $view = View::forge('generate_4word');
    $view->u_id = $usr_id;
    die($view);
  }
}
