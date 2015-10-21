<?php
class Controller_Mypack extends Controller
{
  public function action_index()
  {
    $u_id = Model_Cookie::get_usr();
    if (!$u_id)
    {
      $view = View::forge('404');
      
      die($view);
    }
    $mypack = DB::select()->from('pack')
      ->where('usr_id','=',$u_id)
      ->and_where('id','=',$_GET['p'])
       ->execute()->as_array();
    if (!isset($mypack[0]['id']))
    {
      $view = View::forge('404');
      
      die($view);
    }
    $my_pay_q = DB::select()->from('pay_q')
      ->where('pack_id','=',$mypack[0]['id'])
      ->execute()->as_array();
    $q_amt = count($my_pay_q);
    
    $view = View::forge('mypack');
    $view->pack_txt = $mypack[0]['txt'];
    $view->arr_pack = $my_pay_q;
    $view->q_amt = $q_amt;
    
    $view->u_id = $u_id;
    die($view);
  }
}
