<?php
class Controller_Calling extends Controller
{
  public function action_start()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr('u_id');
    // when receiver access 
    if ( isset($_POST['receiver']) AND isset($_POST['sender']) ) {
        if ($_POST['receiver'] == $usr_id) {
            $query = DB::select()->from('message')
                ->where('receiver','=',$usr_id)
                ->where('sender','=',$_POST['sender'])
                ->order_by('create_at', 'desc')
                ->limit(1)->execute()->as_array();
            if ( $query[0]['create_at'] > date("Y-m-d H:i:s",strtotime("-1 minute")) ) {
                Session::set('sender', $_POST['sender']);
                Session::set('start', time());
                $res[0] = 1;
                $res[1] = 'staring';
                die(json_encode($res));
            }
        }
    }


    die(json_encode($res));
  }
  public function action_end()
  {
    header("Content-Type: application/json; charset=utf-8");
    $res[0] = 2;
    $usr_id = Model_Cookie::get_usr();
    if (!$usr_id) {
        die(json_encode($res));
    }
    if ( Session::get('start') AND Session::get('sender') ) {
        $minutes = floor( (time() - Session::get('start')) / 60 );
        $point = $minutes * 5;
        DB::query("UPDATE usr SET point = point - ".$point." WHERE id = ".Session::get('sender'))->execute();
        DB::query("UPDATE usr SET point = point + ".$point." WHERE id = ".$usr_id)->execute();
        Session::delete('sender');
        Session::delete('start');
        
        $res[0] = 1;
        $res[1] = 'you got '.$point;
    }
    die(json_encode($res));
  }
}
