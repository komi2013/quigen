<?php
class Controller_Pack extends Controller
{
  public function action_index()
  {
    $paid_usr = DB::select()->from('paid_usr')
      ->where('usr_id','=',Model_Cookie::get_usr())
      ->and_where('pack_id','=',$_GET['p'])
      ->execute()->as_array();
    $view = View::forge('pack');
    $pack = DB::select()->from('pack')
      ->where('id','=',$_GET['p'])
      ->execute()->as_array();
    if ( !isset($paid_usr[0]['id']) )
    {
      $res = DB::select()->from('question')
        ->where('id','=',$pack[0]['sample_q'])
        ->execute()->as_array();
      $view = View::forge('request_point');
      $view->sample_q = $res;
      
      die($view);
    }
    
    $view->pack = $pack;
    
    die($view);
  }
}
