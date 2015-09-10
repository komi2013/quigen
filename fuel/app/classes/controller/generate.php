<?php
class Controller_Generate extends Controller
{
  public function action_index()
  {
    Model_Csrf::setcsrf();
    $usr_id = Model_Cookie::get_usr();
    $query = DB::select()->from('question')
      ->where('usr_id','=',$usr_id)
      ->order_by('open_time', 'desc')
      //->limit(20)
      ->execute()->as_array();
    
    $now = new DateTime("now");
    if ( isset($query[0]['open_time']) ) {
      $available = new DateTime($query[0]['open_time']);
      $now_limit = new DateTime("now");
      $now_limit->add( new DateInterval('P30D') );
      
      if ( $query[0]['open_time'] > "2100-01-01 00:00:00" ) {
        $available->sub( new DateInterval('P100Y') );
      }
      
      if ($now_limit < $available) {
        $available->sub( new DateInterval('P30D') );
        $view = View::forge('generate_limited');
        $view->available = $available->format('Y-m-d H:i:s');
        
        die($view);
      }
//      $last_open_time = new DateTime($query[0]['open_time']);
//      $last_open_time->add( new DateInterval('PT1H'));
//
//      if ($now < $last_open_time) {
//        
//        $open_time = $last_open_time->format('Y-m-d H:i:s');
//      } else {
//        $open_time = $now->format('Y-m-d H:i:s');
//      }
//    } else {
//      $open_time = $now->format('Y-m-d H:i:s');
    }
    //Model_Cookie::set('open_time', $open_time);
    $view = View::forge('generate');
    $view->u_id = $usr_id;
    
    die($view);
  }
}
