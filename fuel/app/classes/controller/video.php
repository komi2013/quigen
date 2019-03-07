<?php
class Controller_Video extends Controller
{
  public function action_index()
  {
    $view = View::forge('video');
    $usr_id = Model_Cookie::get_usr('u_id');
    // when receiver access 
    if ( isset($_GET['receiver']) AND isset($_GET['sender']) ) {
        if ($_GET['receiver'] == $usr_id) {
            $query = DB::select()->from('message')
                ->where('receiver','=',$usr_id)
                ->where('sender','=',$_GET['sender'])
                ->order_by('create_at', 'desc')
                ->limit(1)->execute()->as_array();
            if ( $query[0]['create_at'] > date("Y-m-d H:i:s",strtotime("-1 minute")) ) {
                die($view);
            }
        }
        die( View::forge('404') );
    }

    die($view);
  }
}
